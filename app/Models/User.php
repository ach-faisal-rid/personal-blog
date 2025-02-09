<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getProfilePhotoUrlAttribute()
    {
        // Periksa apakah ada gambar profil yang diupload
        if ($this->profile_photo_path) {
            // Kembalikan URL gambar profil yang valid
            return url('storage/' . $this->profile_photo_path);
        }

        /**
        *   Jika tidak ada gambar profil yang diupload, 
        *   Jetstream akan menangani dan memberikan gambar default
        */
        return $this->profile_photo_url;
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            // password akan dienkripsi sebelum disimpan
            set: fn ($value) => bcrypt($value), 
        );
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 
        'role_users', 'user_id', 'role_id'
        )->using(RoleUser::class)->withTimestamps();
    }

    public function hasRole($roleName): bool
    {
        return $this->roles()->whereRaw('LOWER(name) = ?', 
        [strtolower($roleName)])->exists();
    }

    /**
     * Tentukan apakah pengguna dapat mengakses Filament 
     * hanya bisa dibukan oleh admin atau super admin dari role-user.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->roles()->whereIn('name', 
        ['admin', 'super admin']
        )->exists();
    }
}
