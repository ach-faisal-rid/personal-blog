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

    public function postUsers()
    {
        return $this->hasMany(PostUser::class);
    }

    public function authors()
    {
        return $this->hasManyThrough(
            User::class,       // Model tujuan
            PostUser::class,   // Model perantara
            'post_id',         // Foreign key di post_users
            'id',              // Foreign key di users
            'id',              // Primary key di posts
            'role_user_id'     // Foreign key di post_users yang merujuk ke role_users
        )->join('role_users', 'post_users.role_user_id', '=', 'role_users.id')
         ->select('users.*');
    }

    public function comments()
    {
        return $this->hasManyThrough(
            Comment::class,  // Model tujuan
            PostUser::class, // Model perantara
            'post_id',       // Foreign key di post_users
            'post_user_id',  // Foreign key di comments
            'id',             // Primary key di posts
            'id'              // Foreign key di post_users
        );
    }
}
