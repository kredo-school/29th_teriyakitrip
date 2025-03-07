<?php

namespace App\Models;

use App\Models\Regions;//Sunao
use App\Models\Itineraries;//Sunao
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefectures extends Model
{
    use HasFactory;
    
    protected $table = 'prefectures'; // specify the table name if it's different from the default
    protected $fillable = ['name', 'region_id']; 

    /**
    * Relationships with Regions (many-to-one)
     */
    public function regions()//Sunao
    {
        return $this->belongsTo(Regions::class, 'region_id'); 
    }

// **Many to Many(prefectures ↔ itineraries)**
    public function itineraries()//Sunao
    {
        return $this->belongsToMany(Itineraries::class, 'itinerary_prefectures', 'prefecture_id', 'itinerary_id');
    }
}
