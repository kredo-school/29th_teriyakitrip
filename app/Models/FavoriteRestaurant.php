<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteRestaurant extends Model
{
    use HasFactory;

    // タイムスタンプ（created_at, updated_at）を使用しない
    public $timestamps = false;

    // 登録可能なフィールドを指定
    protected $fillable = ['user_id', 'place_id'];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このお気に入りに紐づく最新のレストランレビューを取得（place_idベースで）
     */
    public function review()
    {
        return $this->hasOne(\App\Models\RestaurantReview::class, 'place_id', 'place_id')->latestOfMany();
    }
}
