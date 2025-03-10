<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefecture extends Model
{
    use HasFactory;
    
    protected $table = 'prefectures'; // テーブル名を明示的に指定

    protected $fillable = ['name', 'region_id']; 

    // **Many to One（Regions ↔ Prefectures）**
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id'); 
    }

    // **Many to Many(prefectures ↔ itineraries)**
    public function itineraries()
    {
        return $this->belongsToMany(Itinerary::class, 'itinerary_prefectures', 'prefecture_id', 'itinerary_id');
    }
}
