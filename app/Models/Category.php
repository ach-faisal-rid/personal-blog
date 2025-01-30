<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'categories';
    protected $fillable = ['name', 'icon', 'slug', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 
        'post_categories',
        'category_id',
        'post_id')
        ->withPivot('id');
    }
}
