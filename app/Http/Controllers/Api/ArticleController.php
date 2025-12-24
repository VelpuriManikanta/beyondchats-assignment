<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index()
    {
        return response()->json(
            Article::latest()->get()
        );
    }

    // GET /api/articles/{id}
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    // POST /api/articles
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'source_url' => 'required|string',
            'is_updated' => 'boolean',
        ]);

        $article = Article::create($data);

        return response()->json($article, 201);
    }

    // PUT /api/articles/{id}
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'source_url' => 'sometimes|string',
            'is_updated' => 'sometimes|boolean',
        ]);

        $article->update($data);

        return response()->json($article);
    }

    // DELETE /api/articles/{id}
    public function destroy($id)
    {
        Article::destroy($id);
        return response()->json(['message' => 'Article deleted']);
    }
}
