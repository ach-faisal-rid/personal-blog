<?php

namespace App\Http\Controllers\Landing;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ContentManagement\Entities\Post;

class PostController extends Controller
{
    // index
    public function index(Request $request) {
        $search = $request->input('filter');  // Pencarian berdasarkan judul
        $sort = $request->input('sort', 'latest'); // Default ke 'latest' jika tidak dipilih

        // Query dengan filter dan sorting
        $posts = Post::with(['thumbnail', 'category', 'author'])
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
    public function show($id)
    {
        $post = Post::with([
            'category', 'author', 'thumbnail'
        ])->findOrFail($id);

        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }

}
