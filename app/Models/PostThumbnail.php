<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostThumbnail extends Pivot
{
    use HasFactory;
    protected $table = "post_thumbnails";

    protected $fillable = [
        'post_id',
        'thumbnail_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function thumbnail() {
        return $this->belongsTo(Thumbnail::class);
    }
}
