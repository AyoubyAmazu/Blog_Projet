<?php

namespace Modules\Blog\Controllers;


use Illuminate\Http\Request;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Comment;
use Modules\core\controllers\Controller ;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::All();
        return view("Blog::admin.comment.index", compact("comments"));
    }

    /**
     * Display comments for a specific article.
     */
    public function indexByArticle(Article $article)
    {
        $comments = $article->comments;
        return view("Blog::admin.comment.indexByArticle", compact("comments", "article"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementation for creating a comment (not provided)
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return view("Blog::admin.comment.show", compact("comment"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view("Blog::admin.comment.edit", compact("comment"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);


        return redirect()->route('Blog::comment.show',$comment)->with('success', 'Commentaire modifié avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $articleId)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Find the article
        $article = Article::findOrFail($articleId);

        // Create and save the comment
        $article->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(), // Assuming the user is logged in
        ]);

        // Redirect back with a success message
        return redirect()
            ->route('Blog::public.public.show', $article->id)
            ->with('success', 'Your comment has been added!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('Blog::comment.index')
            ->with('success', 'Commentaire supprimé avec succès.');
    }

    public function destroyByArticle(Comment $comment)
    {
        $article = $comment->article;
        $comment->delete();

        return redirect()
            ->route('Blog::comment.indexByArticle', $article)
            ->with('success', 'Commentaire supprimé avec succès.');
    }
}
