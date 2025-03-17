<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    // index
    public function index(Request $request) {
        $search = $request->input('filter');  // Pencarian berdasarkan judul
        $sort = $request->input('sort', 'latest'); // Default ke 'latest' jika tidak dipilih

        // Query dengan filter dan sorting
        $posts = Post::with(['thumbnails', 'categories', 'authors'])
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->when($sort === 'oldest', function ($query) {
            return $query->oldest();
        }, function ($query) {
            return $query->latest();
        })
        ->paginate(10);

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
