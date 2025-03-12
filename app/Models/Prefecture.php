<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefecture extends Model
{
    use HasFactory;
    
    protected $table = 'prefectures'; // specify the table name if it's different from the default
    protected $fillable = ['name', 'region_id']; 

    /**
    * Relationships with Regions (many-to-one)
     */
    public function regions()
    {
        return $this->belongsTo(Region::class, 'region_id'); 
    }

    /**
     * Relationships (many-to-many) with Itineraries
     */
    public function itineraries()
    {
        return $this->belongsToMany(Itinerary::class);
    }
    public function reviews()
    {
        return $this->hasMany(RestaurantReview::class);
    }
}
