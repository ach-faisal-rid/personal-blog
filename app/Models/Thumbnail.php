<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use HasFactory;
    protected $fillable = ['url'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 
        'post_thumbnails',
        'thumbnail_id',
        'post_id')
        ->withPivot('id');
    }
}
