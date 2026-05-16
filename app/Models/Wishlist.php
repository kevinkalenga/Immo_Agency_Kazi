<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
     protected $guarded = [];
     
     // One wishlist belongs to a property
     public function property() {
          return $this->belongsTo(Property::class, 'property_id', 'id');
     }
}
