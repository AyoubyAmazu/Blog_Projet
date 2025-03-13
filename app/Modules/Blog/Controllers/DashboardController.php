<?php

namespace Modules\Blog\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Comment;
use Modules\core\controllers\Controller ;


class DashboardController extends Controller
{
    

    public function index(){

        $totalUsers = User::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();
        $totalArticles = Article::count();
        return view('Blog::admin.dashboard',
        compact('totalUsers','totalComments','totalCategories','totalArticles'));
    }
}

