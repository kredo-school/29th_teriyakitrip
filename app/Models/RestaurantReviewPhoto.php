<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RestaurantReviewPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_review_id',
        'photo',
    ];

    /**
     * 1つの写真は1つのレビューに属する
     */
    public function review()
    {
        return $this->belongsTo(RestaurantReview::class, 'restaurant_review_id');
    }
}
