<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prefectures extends Model {
    use HasFactory;
    protected $table = 'prefectures'; // specify the table name if it's different from the default
    protected $fillable = ['name', 'region_id'];

    public function regions() {
        return $this->belongsTo(Regions::class,'region_id');
    }
}
