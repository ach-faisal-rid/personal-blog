<?php

namespace Modules\ContentManagement\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'title', 'description', 
        'social_url', 'slug',
        'published_at', 'view_count',
        'category_id', 'user_id',
        'thumbnail_id', 'status'
    ];

    // Relasi ke Category (Many-to-One)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke User (Many-to-One)
    public function author() // atau bisa juga dinamai 'user'
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Thumbnail (Many-to-One)
    public function thumbnail()
    {
        return $this->belongsTo(Thumbnail::class, 'thumbnail_id');
    }

}
