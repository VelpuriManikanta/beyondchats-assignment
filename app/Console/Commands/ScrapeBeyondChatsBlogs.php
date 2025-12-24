<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Article;

class ScrapeBeyondChatsBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:beyondchats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape the 5 oldest BeyondChats blog articles';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $this->info('Fetching BeyondChats blogs page...');

    $response = Http::get('https://beyondchats.com/blogs/');

    if (!$response->successful()) {
        $this->error('Failed to fetch blogs page');
        return;
    }

    $crawler = new Crawler($response->body());

    // Collect all links
    $links = $crawler->filter('a')->each(function ($node) {
        return $node->attr('href');
    });

    // Filter only real blog article URLs
    $blogLinks = array_filter($links, function ($link) {
        return $link
            && str_starts_with($link, 'https://beyondchats.com/blogs/')
            && !str_contains($link, '/tag/')
            && !str_contains($link, '/page/');
    });

    // Remove duplicates and take oldest 5
    $blogLinks = array_slice(array_unique($blogLinks), -5);

    foreach ($blogLinks as $link) {
        $this->info("Scraping: $link");

        if (Article::where('source_url', $link)->exists()) {
            $this->warn('Already exists, skipping...');
            continue;
        }

        $articleResponse = Http::get($link);
        if (!$articleResponse->successful()) {
            continue;
        }

        $articleCrawler = new Crawler($articleResponse->body());

        // Safe title extraction
        $title = $articleCrawler->filter('h1')->count()
            ? trim($articleCrawler->filter('h1')->first()->text())
            : 'Untitled Article';

        // Safe content extraction
        $paragraphs = $articleCrawler->filter('article p')->count()
            ? $articleCrawler->filter('article p')->each(fn ($p) => trim($p->text()))
            : $articleCrawler->filter('p')->each(fn ($p) => trim($p->text()));

        $content = implode("\n\n", array_filter($paragraphs));

        // Skip very short / invalid pages
        if (strlen($content) < 300) {
            $this->warn('Content too short, skipping...');
            continue;
        }

        Article::create([
            'title' => $title,
            'content' => $content,
            'source_url' => $link,
            'is_updated' => false,
        ]);
    }

    $this->info('Scraping completed successfully!');
}


}
