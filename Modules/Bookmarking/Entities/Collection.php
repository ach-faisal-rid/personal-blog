<?php

namespace Modules\Bookmarking\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Bookmarking\Entities\Bookmark;
use App\Models\RoleUser;

class Collection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $fillable = [
        'name',
        'bookmark_id'
    ];

    public function bookmarks()
    {
        return $this->belongsToMany(Bookmark::class, 'bookmark_collection');
    }
}