<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Article::orderBy('created_at', 'desc')->get()
        );
    }
}
