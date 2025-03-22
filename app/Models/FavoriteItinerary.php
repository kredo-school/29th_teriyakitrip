<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItinerary extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'itinerary_id'];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}

