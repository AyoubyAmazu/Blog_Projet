<?php

namespace Modules\Blog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Modules\Blog\services\ArticleService;
use Modules\core\controllers\Controller ;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected  $articleService;

        public function __construct(ArticleService $articleService)
        {
            $this->articleService = $articleService;
        }
    
    public function index()
    {
        $articles = $this->articleService->paginate(5);
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
        $valideted["user_id"]=Auth::user()->id;
        $valideted["category_id"] = $valideted['category'];
        $article = $this->articleService->create($valideted);
        $article->tags()->attach($request->tags);

        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = $this->articleService->find($id);
        return view('Blog::admin.article.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = $this->articleService->find($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('Blog::admin.article.edit',compact('article','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $valideted = $request->validate([
            'title'=> 'required',
            'content'=> 'required',
            'category'=> 'required',
            'tags'=>'array',
            'tags.*' => 'exists:tags,id'
        ]);


        $valideted['category_id'] = $valideted['category'];
        $article = $this->articleService->update($id,$valideted);
        $article->tags()->sync($request->tags);

        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $this->articleService->delete($id);
        return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    }
}
