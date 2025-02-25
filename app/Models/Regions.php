<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model {
    use HasFactory;
    protected $table = 'regions'; // specify the table name if it's different from the default
    protected $fillable = ['name'];

    public function prefectures() {
        return $this->hasMany(Prefectures::class, 'region_id');
    }
}

