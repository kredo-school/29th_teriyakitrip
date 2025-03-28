<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItinerary extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'itinerary_id'];

    // ✅ これを追加！created_at / updated_at を使わないよーという意味
    public $timestamps = false;

    // Itineraryとのリレーション
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    // RestaurantReviewとのリレーション
    public function restaurantReview()
    {
        return $this->hasOne(\App\Models\RestaurantReview::class, 'place_id', 'place_id');
    }
}



