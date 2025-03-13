<?php

namespace Modules\Blog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Models\Article ;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Modules\core\controllers\Controller ;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::paginate(4);
        return view('Blog::admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('Blog::admin.article.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valideted = $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'category'=> 'required',
            'tags'=>'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $article = Article::create([
            'title'=> $valideted['title'],
            'content'=> $valideted['content'],
            'user_id'=>Auth::user()->id,
            'category_id'=> $valideted['category'],
        ]);
        $article->tags()->attach($request->tags);



        return redirect()->route('Blog::article.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('Blog::admin.article.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('Blog::admin.article.edit',compact('article','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $valideted = $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'category'=> 'required',
            'tags'=>'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $article->update([
            'title'=> $valideted['title'],
            'content'=> $valideted['content'],
            'category_id'=> $valideted['category'],
        ]);
        $article->tags()->sync($request->tags);

        return redirect()->route('Blog::article.index')->with('success', 'Article créé avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Article $article)
    {
        // $article = Article::find($id);
        $article->delete();
        return redirect()->route('Blog::article.index')->with('success', 'Article supprimé avec succès.');
    }
}
