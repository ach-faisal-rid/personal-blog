<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    // Menampilkan semua post di landing page
    public function index()
    {
        // Ambil semua post
        $posts = Post::all();

        // Kirim data ke Inertia (Vue)
        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    // Menampilkan detail satu post berdasarkan ID atau slug
    public function show($id)
    {
        // Cari post berdasarkan id
        $post = Post::findOrFail($id);

        // Kirim data post ke halaman show
        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    }
}
