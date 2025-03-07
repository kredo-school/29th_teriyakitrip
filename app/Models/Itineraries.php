<?php

namespace App\Models;

use App\Models\User;//Sunao
use App\Models\Prefectures;//Sunao
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;//sunao

class Itineraries extends Model
{
    use HasFactory;
    protected $table = 'itineraries'; // 明示的にテーブル名を指定
    
    protected $fillable = [
        'user_id',//sunao
        'title', //sunao
        'start_date', //sunao
        'end_date', //sunao
        'photo'];//sunao

        // **One to Many(users ↔ itineraries)**  
          public function user()
    {
        return $this->belongsTo(User::class);
    }

    // **Many to Many(itineraries ↔ prefectures)**
    public function prefectures()//sunao
    {
        return $this->belongsToMany(Prefectures::class, 'itinerary_prefectures', 'itinerary_id', 'prefecture_id');
    }
}

