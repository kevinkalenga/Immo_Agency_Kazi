<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePlan extends Model
{
     protected $guarded = [];
     
    //  one package history belongs to a user
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
