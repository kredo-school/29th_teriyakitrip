<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;//Sunao
use Illuminate\Database\Eloquent\Model;

class ItineraryPrefectures extends Model
{
    use HasFactory;

    protected $table = 'itinerary_prefectures'; // ✅ テーブル名を明示的に指定//sunao

    protected $fillable = [
        'itinerary_id',
        'prefecture_id',
    ];//sunao

    public $timestamps = false; // ✅ `timestamps` を無効にする（必要に応じて）//sunao

    // ✅ Itineraries（旅程）とのリレーション
    public function itinerary()//sunao
    {
        return $this->belongsTo(Itineraries::class, 'itinerary_id');
    }

    // ✅ Prefectures（都道府県）とのリレーション
    public function prefecture()//sunao
    {
        return $this->belongsTo(Prefectures::class, 'prefecture_id');
    }
}