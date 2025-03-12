<?php

namespace App\Models;

use App\Models\Prefecture;//Sunao
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;
    
    protected $table = 'regions'; // specify the table name if it's different from the default
    protected $fillable = ['name'];

    /**
     * Relationships with Prefectures (one-to-many)
     */
    public function prefectures()//Sunao
    {
        return $this->hasMany(Prefecture::class, 'region_id');
    }

    #Display color from prefecutures
    #color is from prefectures table
    public function getColorAttribute()//Sunao
    {
        return $this->prefectures()->first()->color ?? '#CCCCCC';
    }
}

