<?php

namespace Modules\Bookmarking\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bookmarking\Entities\Collection; 
use App\Models\RoleUser;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';

    protected $fillable = [
        'title',
        'url',
        'description',
        'collection_id', // kalau kamu pakai collection juga
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'bookmark_collection');
    }
}
