<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $articles = Article::orderBy('created_at', 'desc')->get();

        return view('index', compact('articles'));
    }
}
