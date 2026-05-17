<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compare extends Model
{
    protected $guarded = [];
      // One compare list belongs to a property
     public function property() {
          return $this->belongsTo(Property::class, 'property_id', 'id');
     }
}
