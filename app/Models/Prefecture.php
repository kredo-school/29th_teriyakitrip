<?php

namespace App\Models;

use App\Models\Region;//Sunao
use App\Models\Itinerary;//Sunao
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefecture extends Model
{
    use HasFactory;
    
    
    protected $fillable = ['name', 'region_id']; 

    /**
    * Relationships with Regions (many-to-one)
     */
    public function region()//Sunao
    {
        return $this->belongsTo(Region::class, 'region_id'); 
    }

// **Many to Many(prefectures ↔ itineraries)**
    public function itinerarie()//Sunao
    {
        return $this->belongsToMany(Itinerary::class, 'itinerary_prefectures', 'prefecture_id', 'itinerary_id');
    }
}
