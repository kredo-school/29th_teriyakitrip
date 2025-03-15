<?php

namespace App\Models;

use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;//Sunao

class ItineraryPrefecture extends Model
{
    use HasFactory;


    protected $fillable = [
        'itinerary_id',
        'prefecture_id',
    ];//sunao

    public $timestamps = false; // ✅ `timestamps` を無効にする（必要に応じて）//sunao

    // ✅ Itineraries（旅程）とのリレーション
    public function itinerary()//sunao
    {
        return $this->belongsTo(Itinerary::class, 'itinerary_id');
    }

    // ✅ Prefectures（都道府県）とのリレーション
    public function prefectures()//sunao
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id');
    }
}
