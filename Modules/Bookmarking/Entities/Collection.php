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
        'role_user_id',
        'name',
        'role_user_id', 
        'bookmark_id'
    ];

    public function roleUser()
    {
        return $this->belongsTo(RoleUser::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Bookmark::class, 'bookmark_collection');
    }

    // Optional: akses user langsung dari collection
    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            RoleUser::class,
            'id',            // foreign key di role_users (role_user_id)
            'id',            // foreign key di users
            'role_user_id',  // local key di collections
            'user_id'        // foreign key di role_users
        );
    }

    // Optional: akses role langsung juga bisa
    public function role()
    {
        return $this->hasOneThrough(
            \App\Models\Role::class,
            RoleUser::class,
            'id',
            'id',
            'role_user_id',
            'role_id'
        );
    }
}