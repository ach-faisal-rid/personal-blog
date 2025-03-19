<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Thumbnail extends Model
{
    use HasFactory;
    protected $fillable = [
        'url', 'image', 'status'
    ];

    protected $appends = ['image_url'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 
        'post_thumbnails',
        'thumbnail_id',
        'post_id')
        ->withPivot('id');
    }

    // Accessor untuk mendapatkan URL gambar (upload atau URL)
    public function getImageUrlAttribute() {
        if($this->image) {
            return url('storage/' . $this->image);
        }
        
        return $this->url;
    }

    // Accessor untuk mengetahui jenis gambar
    public function getThumbnailTypeAttribute() {
        if ($this->image) {
            return 'upload';
        }
        if ($this->url) {
            return 'url';
        }
        return 'none';
    }

}
