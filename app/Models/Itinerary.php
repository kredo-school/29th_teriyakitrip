<?php

namespace App\Models;

use App\Models\User;//Sunao
use App\Models\Prefecture;//Sunao
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;//sunao

class Itinerary extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'title', 'start_date', 'end_date', 'is_public', 'photo'];

// **One to Many(users ↔ itineraries)**  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // **Many to Many(itineraries ↔ prefectures)**
    public function prefectures()//sunao
    {
        return $this->belongsToMany(Prefecture::class, 'itinerary_prefectures', 'itinerary_id', 'prefecture_id');
    }
}
