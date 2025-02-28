<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'user_name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * Get the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default-avatar.png');
    }


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

    // Itineraries リレーション
    public function itineraries()
    {
        return $this->hasMany(Itineraries::class);
    }

    // RestaurantReviews リレーション
    public function restaurantReviews()
    {
        return $this->hasMany(RestaurantReview::class);
    }

    //フォローしているユーザー
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows','following', 'followed');
    }

    //フォローされているユーザー
    public function followed()
    {
        return $this->belongsToMany(User::class, 'follows','followed','following');   
    }

    public function follow($user_id)
    {
        return $this->follows()->attach($user_id);
    }

    public function unfollow($user_id)
    {
        return $this->follows()->detach($user_id);
    }

    public function isFollowing($user_id)
    {
        return (boolean) $this->follows()->where('followed', $user_id)->exists();
    }

    public function isFollowed($user_id)
    {
        return (boolean) $this->followers()->where('following', $user_id)->exists();
    }

    public function reviews()
    {
        return $this->hasMany(RestaurantReview::class, 'user_id');
    }

}
