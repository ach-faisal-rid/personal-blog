<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Thumbnail;
use Inertia\Inertia;

class ThumbnailController extends Controller
{
    // index
    public function index(Request $request) {
        $query = Thumbnail::query();

         // Sorting berdasarkan pilihan user
        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        return Inertia::render("Thumbnail/Index",[
            'thumbnails' => $query->paginate(10),
        ]);
    }

    // show
    public function show($id) {
        $thumbnail = Thumbnail::findOrFail($id);

        return Inertia::render('Thumbnail/Show', [
            'thumbnail' => $thumbnail
        ]);
    }
}
