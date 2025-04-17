<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Bookmarking\Entities\Bookmark;
use Modules\Bookmarking\Entities\Collection;
use App\Models\Role;
use App\Models\User;
use App\Models\PostUser;

class RoleUser extends Pivot
{
    use HasFactory;

    protected $table = 'role_users';
    public $timestamps = true; 

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postUsers()
    {
        return $this->hasMany(PostUser::class, 'role_user_id', 'id');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'role_user_id', 'id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'role_user_id', 'id');
    }
}