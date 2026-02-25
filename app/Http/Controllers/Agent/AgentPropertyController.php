<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\MultiImage;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use Auth;

class AgentPropertyController extends Controller
{
    public function AgentAllPropertie()
    {
      
      // The user who is logged in 
      $id = Auth::user()->id;
      // The id of the agent must match with the id of the property so as to get the data 
      $property = Property::where('agent_id', $id)->latest()->get();
      return view('agent.property.all_property', compact('property'));
    }
}
