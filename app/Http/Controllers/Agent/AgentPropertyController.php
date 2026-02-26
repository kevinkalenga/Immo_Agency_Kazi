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

    public function AgentAddPropertie()
    {
      $propertyType = PropertyType::latest()->get();
      $amenities = Amenities::latest()->get();
     
      return view('agent.property.add_property', compact('propertyType', 'amenities'));
    }


    public function AgentStorePropertie(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'property_thambnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
              // Multi images validation
            'multi_img' => 'nullable|array',
            'multi_img.*' => 'image|mimes:jpg,jpeg,png|max:2048',

            // facility
            'facility_name' => 'nullable|array',
            'facility_name.*' => 'required|string|max:255',
            'distance' => 'nullable|array',
            'distance.*' => 'nullable|string|max:100',
        ]);

        $amenities = $request->amenities_id 
            ? implode(',', $request->amenities_id) 
            : null;
        // dd($amenities);
        
        $pcode = IdGenerator::generate([
           'table' => 'properties',
           'field' => 'property_code',
           'length' => 5,
           'prefix' => 'PC-'
        ]);



          try {

               // Upload thumbnail
               $image = $request->file('property_thambnail');
               $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

               $uploadPath = public_path('uploads/property/thambnail/');
               if (!file_exists($uploadPath)) {
                   mkdir($uploadPath, 0755, true);
               }

               $manager = new ImageManager(new Driver());
               $manager->read($image)
                   ->resize(370, 250)
                   ->save($uploadPath . $name_gen);

               $save_url = 'uploads/property/thambnail/' . $name_gen;

               // Save property
               $property = Property::create([
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
                   'garage' => $request->garage,
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
                   'featured' => $request->featured,
                   'hot' => $request->hot,
                   'agent_id' => Auth::user()->id, //User who is logged in
                   'status' => 1,
                   'property_thambnail' => $save_url,
               ]);

               // Multi images
               if ($request->hasFile('multi_img')) {
                   foreach ($request->file('multi_img') as $img) {

                       $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

                       $uploadPath = public_path('uploads/property/multi_image/');
                       if (!file_exists($uploadPath)) {
                           mkdir($uploadPath, 0755, true);
                       }

                       $manager->read($img)
                           ->resize(770, 520)
                           ->save($uploadPath . $make_name);

                       MultiImage::create([
                           'property_id' => $property->id,
                           'photo_name' => 'uploads/property/multi_image/' . $make_name,
                       ]);
                   }
                }

                
                if ($request->has('facility_name')) {

                    $facilities = count($request->facility_name);

                    for ($i = 0; $i < $facilities; $i++) {

                        $facility = new Facility();
                        $facility->property_id = $property->id;
                        $facility->facility_name = $request->facility_name[$i];
                        $facility->distance = $request->distance[$i] ?? null;
                        $facility->save();
                    }
                }

                
                
                $notification = array(
                 'message' => 'Property Inserted Successfully!',
                 'alert-type' => 'success'
                );

              return redirect()->route('agent.all.propertie')->with($notification);
            

            } catch (\Exception $e) {
                return back()->withErrors([
                    'error' => $e->getMessage(),
                ])->withInput();
            }


    }

    public function AgentEditPropertie($id)
    {
      $facilities = Facility::where('property_id', $id)->get();
      $property = Property::findOrFail($id);
      
      $type = $property->amenities_id;
      $property_ami = explode(',', $type);
            
      $multiImage = MultiImage::where('property_id',$id)->get();
      
      $propertyType = PropertyType::latest()->get();
      $amenities = Amenities::latest()->get();
    

       return view('agent.property.edit_property', compact('property', 'propertyType', 'amenities', 'property_ami' ,'multiImage', 'facilities'));
    }


    public function AgentUpdatePropertie(Request $request, $id)
    {
      
       $request->validate([
        'ptype_id' => 'required|exists:property_types,id',
        'property_name' => 'required|string|max:255',
        'property_status' => 'required|string',
        'lowest_price' => 'required|numeric',
        'max_price' => 'required|numeric',
          // … autres champs nécessaires
    ]);
    
    
       // dd('UPDATE ROUTE TOUCHED');
      $amenities = $request->amenities_id
          ? implode(',', $request->amenities_id)
          : null;

      $property = Property::findOrFail($id);

      $property->update([
        'ptype_id'        => $request->ptype_id,
        'amenities_id'    => $amenities, // ✅ ICI
        'property_name'   => $request->property_name,
        'property_slug'   => Str::slug($request->property_name),
        'property_status' => $request->property_status,
        'lowest_price'    => $request->lowest_price,
        'max_price'       => $request->max_price,
        'short_descp'     => $request->short_descp,
        'long_descp'      => $request->long_descp,
        'bedrooms'        => $request->bedrooms,
        'bathrooms'       => $request->bathrooms,
        'garage'          => $request->garage,
        'garage_size'     => $request->garage_size,
        'property_size'   => $request->property_size,
        'property_video'  => $request->property_video,
        'address'         => $request->address,
        'city'            => $request->city,
        'state'           => $request->state,
        'postal_code'     => $request->postal_code,
        'neighborhood'    => $request->neighborhood,
        'latitude'        => $request->latitude,
        'longitude'       => $request->longitude,
        'featured'        => $request->has('featured') ? 1 : 0,
        'hot'             => $request->has('hot') ? 1 : 0,
        'agent_id'        => Auth::user()->id,
      ]);

      return redirect()->route('agent.all.propertie')->with([
        'message' => 'Property Updated Successfully',
        'alert-type' => 'success'
      ]);
    }


    public function AgentUpdatePropertieThambnail(Request $request)
    {
         $pro_id = $request->id;   // récupère l'id depuis le hidden input

         $oldImage = $request->old_img;
         $image = $request->file('property_thambnail');

         $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

         $uploadPath = public_path('uploads/property/thambnail/');
         if (!file_exists($uploadPath)) {
             mkdir($uploadPath, 0755, true);
         }

        $manager = new ImageManager(new Driver());
        $manager->read($image)
            ->resize(370, 250)
            ->save($uploadPath . $name_gen);

        $save_url = 'uploads/property/thambnail/'.$name_gen;

        if ($oldImage && file_exists(public_path($oldImage))) {
            unlink(public_path($oldImage));
        }

        Property::findOrFail($pro_id)->update([
            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Property Image Thumbnail Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
 
    

  public function AgentUpdatePropertieMultiimage(Request $request)
  {
    if ($request->hasFile('multi_img')) {

        foreach ($request->file('multi_img') as $id => $img) {

            // Find old image
            $imgDel = MultiImage::findOrFail($id);

            // Delete old image file
            if (file_exists(public_path($imgDel->photo_name))) {
                unlink(public_path($imgDel->photo_name));
            }

            // Generate new image name
            $name_gen = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

            // Upload path
            $uploadPath = public_path('uploads/property/multi_image/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Resize & save
            $manager = new ImageManager(new Driver());
            $manager->read($img)
                ->resize(770, 520)
                ->save($uploadPath . $name_gen);

            // Update DB
            MultiImage::where('id', $id)->update([
                'photo_name' => 'uploads/property/multi_image/' . $name_gen,
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    $notification = [
        'message' => 'Property Multi Images Updated Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
  }


  public function AgentPropertieMultiimgDelete($id)
  {
    // Find image record
    $multiImg = MultiImage::findOrFail($id);

    // Delete image file from storage
    if ($multiImg->photo_name && file_exists(public_path($multiImg->photo_name))) {
        unlink(public_path($multiImg->photo_name));
    }

    // Delete DB record
    $multiImg->delete();

    $notification = [
        'message' => 'Property Multi Image Deleted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
  }


}
