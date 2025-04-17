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
        'role_user_id', // hubungan pivot user-role
        'collection_id', // kalau kamu pakai collection juga
    ];

    public function roleUser()
    {
        return $this->belongsTo(RoleUser::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'bookmark_collection');
    }

    // Optional jika mau akses user langsung dari bookmark
    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            RoleUser::class,
            'id',            // foreign key di role_users (role_user_id)
            'id',            // foreign key di users
            'role_user_id',  // local key di bookmarks
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
