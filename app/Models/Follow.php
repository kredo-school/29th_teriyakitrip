<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'following', 'followed'
      ];
    
      public function getFollowCount($user_id)
  {
      return $this->where('following', '<>', $user_id)->count();
  }

  public function getFollowerCount($user_id)
  {
      return $this->where('followed', '<>',  $user_id)->count();
  }
}
