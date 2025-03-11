<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItinerarySpot extends Model
{
    use HasFactory;

    protected $table = 'itinerary_spots';

    protected $fillable = [
        'itinerary_id',
        'place_id',
        'order',
        'visit_time',
        'visit_day'
    ];

    /**
     * 旅程とのリレーション
     */
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
