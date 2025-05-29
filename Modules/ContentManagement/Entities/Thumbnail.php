<?php

namespace Modules\ContentManagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Thumbnail extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'image',
        'status',
    ];

    protected $appends = [
        'image_url',
        'thumbnail_type', // Ditambahkan untuk konsistensi dengan form
    ];

    protected $casts = [
        'status' => 'boolean', // Pastikan status sebagai boolean
    ];

    /**
     * Relasi many-to-many dengan Post.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_thumbnails', 'thumbnail_id', 'post_id')
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

    /**
     * Handler untuk menghapus file fisik saat model dihapus.
     */
    protected static function booted()
    {
        static::deleting(function (Thumbnail $thumbnail) {
            if ($thumbnail->image) {
                Storage::delete($thumbnail->image);
            }
        });
    }
}