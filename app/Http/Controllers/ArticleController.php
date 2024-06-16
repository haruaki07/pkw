<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->role === UserRole::User) {
            $articles = $request->user()
                ->articles()
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $articles = Article::orderBy('created_at', 'desc')
                ->get();
        }

        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|string|max:100",
            "content" => "required|string|max:280"
        ]);

        $request->user()->articles()->create($data);

        return redirect()->route('articles.index')->with('status', 'article-created');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);

        $data = $request->validate([
            "title" => "required|string|max:100",
            "content" => "required|string|max:280"
        ]);

        $article->update($data);

        return redirect()->back()->with('status', 'article-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        return redirect()->back()->with('status', 'article-deleted');
    }
}
