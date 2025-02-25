<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefectures extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'region_id']; 

    /**
    * Relationships with Regions (many-to-one)
     */
    public function regions()
    {
        return $this->belongsTo(Regions::class, 'region_id'); 
    }

    /**
     * Relationships (many-to-many) with Itineraries
     */
    public function itineraries()
    {
        return $this->belongsToMany(Itineraries::class);
    }
}
