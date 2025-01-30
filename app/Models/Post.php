<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = ['title', 'description', 'youtube_url'];

    public function thumbnails()
    {
        return $this->belongsToMany(Thumbnail::class,
         'post_thumbnails',
         'post_id',
        'thumbnail_id')
        ->withPivot('id');
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class,
         'post_categories',
         'post_id',
        'category_id')
        ->withPivot('id');
    }
}
