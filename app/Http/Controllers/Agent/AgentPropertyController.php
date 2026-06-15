<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyMessage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\State;
use App\Models\Schedule;
use App\Models\MultiImage;
use App\Models\PackagePlan;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use DB;

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
      $pState = State::latest()->get();
      $id = Auth::user()->id;

      $property = User::where('role', 'agent')->where('id', $id)->first();
      $pCount = $property->credit;
      //dd($pCount);

      if($pCount == 1 || $pCount == 8) {
        return redirect()->route('buy.package');
      } else {
        return view('agent.property.add_property', compact('propertyType', 'amenities', 'pState'));
      }
     
     
    }


    public function AgentStorePropertie(Request $request)
    {
        $id = Auth::user()->id;
        $uid = User::findOrFail($id);
        $nId = $uid->credit;
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
                   'year_built' => $request->year_built,
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

                User::where('id', $id)->update([
                    'credit' => DB::raw('1 + '.$nId),
                ]);
                
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
      $pState = State::latest()->get();
      $type = $property->amenities_id;
      $property_ami = explode(',', $type);
            
      $multiImage = MultiImage::where('property_id',$id)->get();
      
      $propertyType = PropertyType::latest()->get();
      $amenities = Amenities::latest()->get();
    

       return view('agent.property.edit_property', compact('property', 'propertyType', 'amenities', 'property_ami' ,'multiImage', 'facilities', 'pState'));
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
        'year_built' => $request->year_built,
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
 
    







    public function AgentStoreNewMultiimage(Request $request)
    {
        // Validation
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'multi_img' => 'required|array',
            'multi_img.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $property_id = $request->property_id;

        $manager = new ImageManager(new Driver());
        $uploadPath = public_path('uploads/property/multi_image/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($request->file('multi_img') as $img) {

            $name_gen = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

            $manager->read($img)
                ->resize(770, 520)
                ->save($uploadPath . $name_gen);

            MultiImage::create([
                'property_id' => $property_id,
                'photo_name' => 'uploads/property/multi_image/' . $name_gen,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'New Property Images Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

   

   
   
  


    public function AgentUpdatePropertieFacilities(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'facility_name' => 'nullable|array',
            'facility_name.*' => 'nullable|string|max:255',
            'distance' => 'nullable|array',
            'distance.*' => 'nullable|string|max:255',
        ]);

        $property_id = $request->property_id;

        // sécurisation : éviter delete si vide
        if (!$request->facility_name) {
            return back()->with([
                'message' => 'No facilities provided',
                'alert-type' => 'error'
            ]);
        }

        Facility::where('property_id', $property_id)->delete();

        foreach ($request->facility_name as $index => $facility) {

            if (!empty($facility)) {
                Facility::create([
                    'property_id' => $property_id,
                    'facility_name' => $facility,
                    'distance' => $request->distance[$index] ?? null,
                ]);
            }
        }

        return back()->with([
            'message' => 'Property Facilities Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function AgentDetailsProperty($id)
    {
      $facilities = Facility::where('property_id', $id)->get();
      $property = Property::findOrFail($id);
      
      $type = $property->amenities_id;
      $property_ami = explode(',', $type);
            
      $multiImage = MultiImage::where('property_id',$id)->get();
      
      $propertyType = PropertyType::latest()->get();
      $amenities = Amenities::latest()->get();
     

       return view('agent.property.details_property', compact('property', 'propertyType', 'amenities', 'property_ami' ,'multiImage', 'facilities'));
    
    }


    public function AgentDeletePropertie($id)
    {
        $property = Property::findOrFail($id);

        // Supprimer thumbnail
        if ($property->property_thambnail && file_exists(public_path($property->property_thambnail))) {
            unlink(public_path($property->property_thambnail));
        }

        // Supprimer multi images
        $multiImages = MultiImage::where('property_id', $id)->get();
        foreach ($multiImages as $img) {
            if ($img->photo_name && file_exists(public_path($img->photo_name))) {
                unlink(public_path($img->photo_name));
            }
        }
        MultiImage::where('property_id', $id)->delete();

        // Supprimer facilities
        Facility::where('property_id', $id)->delete();

        // Supprimer la propriété
        $property->delete();

       return redirect()->back()->with([
          'message' => 'Property Deleted Successfully',
          'alert-type' => 'success'
       ]);
    }

    public function BuyPackage()
    {
        return view('agent.package.buy_package');
    }
    public function BuyBusinessPlan()
    {
       
        $id = Auth::user()->id; 
        $data = User::find($id);


        return view('agent.package.business_plan', compact('data'));
    }

    public function StoreBusinessPlan(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Business',
            'package_credits' => 4,
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => 40,
            'created_at' => Carbon::now(),

        ]);

        $user->increment('credit', 4);

        $notification = array(
            'message' => 'You have purchased Business Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()
            ->route('agent.all.propertie')
            ->with($notification);
    }


    public function BuyProfessionalPlan()
    {
        $id = Auth::user()->id;
        $data = User::findOrFail($id);

        return view('agent.package.professional_plan', compact('data'));
    }


    public function StoreProfessionalPlan(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        PackagePlan::insert([

            'user_id' => $id,
            'package_name' => 'Professional',
            'package_credits' => 8,
            'invoice' => 'ERS' . mt_rand(10000000, 99999999),
            'package_amount' => 70,
            'created_at' => Carbon::now(),

        ]);

        $user->increment('credit', 8);

        $notification = array(
            'message' => 'You have purchased Professional Package Successfully',
            'alert-type' => 'success'
        );

        return redirect()
            ->route('agent.all.propertie')
            ->with($notification);
    }

    public function PackageHistory(){

        $id = Auth::user()->id;
        $packagehistory = PackagePlan::where('user_id',$id)->get();
        return view('agent.package.package_history',compact('packagehistory'));

    }

    public function AgentPackageInvoice($id)
    {
        $packagehistory = PackagePlan::where('id', $id)->firstOrFail();

        $pdf = Pdf::loadView(
            'agent.package.package_history_invoice',
            compact('packagehistory')
        )
        ->setPaper('a4')
        ->setOptions([
            'tempDir' => public_path(),
            'chroot'  => public_path(),
        ]);

        return $pdf->download('invoice.pdf');
    }
    public function AgentPropertieMessage()
    {
        // user auth id
        $id = Auth::user()->id;
        // when this will match
        $userMsg = PropertyMessage::where('agent_id', $id)->get();

        return view('agent.message.all_message', compact('userMsg'));
    }
    public function AgentMessageDetails($id)
    {
        
        $agentId = Auth::id();

        $userMsg = PropertyMessage::where('agent_id', $agentId)->get();

        $msgDetails = PropertyMessage::where('agent_id', $agentId)
                        ->findOrFail($id);

        return view(
            'agent.message.message_detail',
            compact('userMsg', 'msgDetails')
        );
    }

    public function AgentScheduleRequest()
    {
        // user who is logged in
        $id = Auth::user()->id;
        $userMsg = Schedule::where('agent_id', $id)->get();

        return view('agent.schedule.schedule_request', compact('userMsg'));
    }

   
}
