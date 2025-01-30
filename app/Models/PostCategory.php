<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostCategory extends Pivot
{
    use HasFactory;
    protected $table='post_categories';
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
