<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
      $propertyType = PropertyType::latest()->get();
      $amenities = Amenities::latest()->get();
      $activeAgent = User::where('status', 'active')->where('role', 'agent')->latest()->get();
      return view('backend.property.add_property', compact('propertyType', 'amenities', 'activeAgent'));
    }

    public function StorePropertie(Request $request)
    {
        // ✅ Validate request inputs
        $request->validate([
            'property_thambnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);
        // dd($amenities);
        
        $pcode = IdGenerator::generate([
           'table' => 'properties',
           'field' => 'property_code',
           'length' => 5,
           'prefix' => 'PC-'
        ]);
        
        
        
        try {
            if ($request->hasFile('property_thambnail')) {
                $image = $request->file('property_thambnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $uploadPath = public_path('uploads/property/thambnail');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Use the new Intervention Image v3 syntax
                $manager = new ImageManager(new Driver());
                $manager->read($image)
                    ->resize(370, 250)
                    ->save($uploadPath . '/' . $name_gen);

                $save_url = 'uploads/property/thambnail' . $name_gen;
            } else {
                return back()->withErrors(['property_thambnail' => 'No property thambnail uploaded.']);
            }

            // Save to database
            Property::insert([
                'ptype_id' => $request->ptype_id,
                'amenities_id' => $amenities,
                'property_name' => $request->property_name,
                'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
                'property_code' => $pcode,
                'property_status' => $request->property_status,
                'lowest_price' => $request->lowest_price,
                'max_price' => $request->max_price,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'bedrooms' => $request->bedrooms,
                'bathrooms' => $request->bathrooms,
                'garage' => $garage,
                'garage_size' => $request->garage_size,
                'property_size' => $request->property_size,
                'property_video' => $request->property_video,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'neighborhood' => $request->neighborhood,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'featured' => $featured,
                'hot' => $request->hot,
                'agent_id' => $request->agent_id,
                'status' => 1,
                'property_thambnail' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->route('all.property')->with([
                'message' => 'Property thambnail Inserted Successfully!',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Something went wrong: ' . $e->getMessage(),
            ])->withInput();
        }
    }
}
