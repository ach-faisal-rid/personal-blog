<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    // index
    public function index() {
        $posts = Post::with(
                ['thumbnails', 'categories', 'authors']
            )->latest()->paginate(10);
        return Inertia::render("Posts/Index",[
            "posts" => $posts
        ]);
    }
    // show
    public function show($id) {
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Show', [
            'post' => $post->load(
                ['thumbnails', 'categories', 
                            'authors', 'comments.postUser.user']
            ),  // Load relations
        ]);
    }
}
