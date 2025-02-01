<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    use HasFactory;
    protected $table = "post_users";
    protected $fillable = [
        'role_user_id', 
        'post_id'
    ];
    
    public function roleUser () {
        return $this->belongsTo(RoleUser::class, 'role_user_id');
    }

    public function post (){
        return $this->belongsTo(Post::class);
    }
}
