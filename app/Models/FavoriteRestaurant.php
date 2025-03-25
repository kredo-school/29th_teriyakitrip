<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteRestaurant extends Model
{
    use HasFactory;

    public $timestamps = false; // 🚨 `updated_at` と `created_at` を使わないようにする

    protected $fillable = ['user_id', 'place_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

