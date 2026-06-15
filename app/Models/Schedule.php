<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
     protected $guarded = [];

      public function user() {
          return $this->belongsTo(User::class, 'user_id', 'id');
    }
    

     // property_id vient de Schedule table    
    
    public function property() {
          return $this->belongsTo(Property::class, 'property_id', 'id');
    }
}
