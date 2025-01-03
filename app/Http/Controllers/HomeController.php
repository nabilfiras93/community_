<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Post;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categorieList = new Categorie;
        $categorieCollection = $categorieList->all();
        $postList = new Post;
        $postCollection = $postList->leftJoin('likes', 'likes.post_id', '=', 'posts.id')
            ->select('posts.*', 'likes.user_id as user_like')
            ->where('posts.is_approved','1')
            ->orderBy('posts.updated_at', 'desc')->get();
        return view('home')->with('categorieRows', $categorieCollection)->with('postRows', $postCollection);
    }
}
