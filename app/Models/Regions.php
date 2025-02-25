<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regions extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relationships with Prefectures (one-to-many)
     */
    public function prefectures()
    {
        return $this->hasMany(Prefectures::class, 'region_id');
    }

    #Display color from prefecutures
    #color is from prefectures table
    public function getColorAttribute()
    {
        return $this->prefectures()->first()->color ?? '#CCCCCC';
    }
}
