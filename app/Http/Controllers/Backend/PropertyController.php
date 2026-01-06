<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\MultiImage;

class PropertyController extends Controller
{
    public function AllPropertie()
    {
      // get all the data 
      $property = Property::latest()->get();
      return view('backend.property.all_property', compact('property'));
    }
    public function AddPropertie()
    {
      return view('backend.property.add_property');
    }
}
