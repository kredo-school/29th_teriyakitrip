<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItineraryPrefecture extends Model
{
    use HasFactory;

    protected $table = 'itinerary_prefectures'; 

    protected $fillable = [
        'itinerary_id',
        'prefecture_name',
    ];

    public $timestamps = false; // `timestamps` を無効化（必要に応じて）

    // **Itinerary（旅程）とのリレーション**
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    // **Prefecture（都道府県）とのリレーション**
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id');
    }
}
