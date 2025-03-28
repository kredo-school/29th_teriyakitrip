<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RestaurantReview extends Model
{
    use HasFactory, SoftDeletes; // ソフトデリートを適用

    protected $fillable = [
        'user_id',
        'place_id',
        'prefecture_id',
        'rating',
        'title',
        'body',
        'photo', // メイン画像
        'restaurant_name', 
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    /**
     * 1つのレビューには複数の写真がある
     */
    public function photos()
    {
        return $this->hasMany(RestaurantReviewPhoto::class, 'restaurant_review_id');
    }

    /**
     * ユーザーとのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * ユーザーがそのレストランをお気に入りにしているかどうかを判定する
     */
    public function isFavorite() //TOSHIMI
    {
        return FavoriteRestaurant::where('user_id', auth()->id())
            ->where('place_id', $this->place_id)
            ->exists();
    }
}
