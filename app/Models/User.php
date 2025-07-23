<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'banner',
        'bio',
        'location',
        'website',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        if (!empty($this->attributes['avatar'])) {
            // Handle both full path (avatars/filename.ext) and just filename
            $avatarPath = $this->attributes['avatar'];
            
            // If it doesn't contain 'avatars/', prepend it
            if (!str_contains($avatarPath, 'avatars/')) {
                $avatarPath = 'avatars/' . $avatarPath;
            }
            
            return asset('storage/' . $avatarPath);
        }

        return asset('images/default-avatar.png');
    }
    
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     * Get users that this user is following
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    /**
     * Get users that follow this user
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->getKey())->exists();
    }

    /**
     * Get the user's banner URL
     */
    public function getBannerUrlAttribute()
    {
        if (!empty($this->attributes['banner'])) {
            // Handle both full path (banners/filename.ext) and just filename
            $bannerPath = $this->attributes['banner'];
            
            // If it doesn't contain 'banners/', prepend it
            if (!str_contains($bannerPath, 'banners/')) {
                $bannerPath = 'banners/' . $bannerPath;
            }
            
            return asset('storage/' . $bannerPath);
        }

        return asset('images/default-banner.jpg');
    }
}
