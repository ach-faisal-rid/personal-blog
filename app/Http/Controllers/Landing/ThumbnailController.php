<?php

namespace App\Http\Controllers\Landing;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\ContentManagement\Entities\Thumbnail;

class ThumbnailController extends Controller
{
    // index
    public function index(Request $request) {
        $query = Thumbnail::where('status', 1); 

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
