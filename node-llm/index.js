import axios from "axios";
import "dotenv/config";
import { scrapeArticle } from "./scrape.js";
import { googleSearch } from "./search.js";


const API = process.env.LARAVEL_API;

async function getLatestArticle() {
  const res = await axios.get(`${API}/articles`);
  return res.data[0];
}

async function main() {
  // 1. Fetch latest article from Laravel
  const article = await getLatestArticle();
  console.log("Latest article:", article.title);

  // 2. Google search using article title
  const results = await googleSearch(article.title);
  console.log("Google results:", results);

  // 3. Scrape two external articles
  const ref1 = await scrapeArticle(results[0].link);
  const ref2 = await scrapeArticle(results[1].link);

  console.log("Reference 1 length:", ref1.length);
  console.log("Reference 2 length:", ref2.length);

  // 4. Combine content (NO LLM)
  const combinedContent = `
${article.content}

---

### Reference Article 1
${ref1}

---

### Reference Article 2
${ref2}

---

### References
1. ${results[0].link}
2. ${results[1].link}
`;

  // 5. Publish updated article back to Laravel
  await axios.post(`${API}/articles`, {
    title: article.title + " (Updated – Scraped)",
    content: combinedContent,
    source_url: "scraped-references",
    is_updated: true,
  });

  console.log("✅ Updated article (scraping-only) published");
}

main();
