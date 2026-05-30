<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\PackagePlan;
use App\Models\User;
use App\Models\State; 
use App\Models\MultiImage;
use App\Models\PropertyMessage;
use Carbon\Carbon;
use Auth;


class IndexController extends Controller
{
    public function PropertyDetails($id, $slug)
    {
        $property = Property::findOrFail($id);
        $amenities = $property->amenities_id;
        $property_amen = explode(',', $amenities);
        $multiImage = MultiImage::where('property_id', $id)->get();
        $facility = Facility::where('property_id', $id)->get();
        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id', $type_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->limit(3)->get();
        
        return view('frontend.property.property_details', compact('property', 'multiImage', 'property_amen', 'facility', 'relatedProperty'));
    }
    public function PropertyMessage(Request $request)
    {
        $pId = $request->property_id;
        $aId = $request->agent_id;

        if (Auth::check()) {
            
            PropertyMessage::insert([

                'user_id' => Auth::user()->id,
                'agent_id' => $aId,
                'property_id' => $pId,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(), 

            ]);

            $notification = array(
                'message' => 'Send Message Successfully',
                'alert-type' => 'success'
            );

           return redirect()->back()->with($notification);



        }else{

            $notification = array(
            'message' => 'Please Login first in order to send the message',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
        }
    }

    public function AgentDetail($id)
    {
      $agent = User::findOrFail($id);

      $property = Property::where('agent_id', $id)->get();
      
      $featured = Property::where('featured', '1')->limit(3)->get();

      $rentProperty = Property::where('property_status', 'rent')->get();


      $buyProperty = Property::where('property_status', 'buy')->get();

      return view('frontend.agent.agent_details', compact('agent', 'property', 'featured', 'rentProperty', 'buyProperty'));
    }


    public function AgentDetailsMessage(Request $request)
    {
       
        $aId = $request->agent_id;

        if (Auth::check()) {
            
            PropertyMessage::insert([

                'user_id' => Auth::user()->id,
                'agent_id' => $aId,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(), 

            ]);

            $notification = array(
                'message' => 'Send Message Successfully',
                'alert-type' => 'success'
            );

           return redirect()->back()->with($notification);



        }else{

            $notification = array(
            'message' => 'Please Login first in order to send the message',
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
        }
    }

    public function RentProperty()
    {
        $rProperty = Property::where('status', '1')->where('property_status', 'rent')->paginate(3);
        $bProperty = Property::where('status', '1')
                ->where('property_status', 'buy')
                ->get();

        
      return view('frontend.property.rent_property', compact('rProperty', 'bProperty'));

    }
    public function BuyProperty()
    {
         $bProperty = Property::where('status', '1')->where('property_status', 'buy')->paginate(3);

          $rProperty = Property::where('status', '1')
                ->where('property_status', 'rent')
                ->get();

        
      return view('frontend.property.buy_property', compact('bProperty', 'rProperty'));

    }
    public function PropertyType($id)
    {
         $propertyType = Property::where('status', '1')->where('ptype_id', $id)->get();

        $bProperty = Property::where('status', '1')->where('property_status', 'buy')->get();

        $rProperty = Property::where('status', '1')
                ->where('property_status', 'rent')
                ->get();
        $pBread = PropertyType::where('id', $id)->first();

         
         return view('frontend.property.property_type', compact('propertyType', 'bProperty', 'rProperty', 'pBread'));

    }

    public function StateDetails($id){

       $property = Property::where('status','1')->where('state',$id)->get();

       $bstate = State::where('id',$id)->first();
        return view('frontend.property.state_property',compact('property','bstate'));

    }
   

    public function BuyPropertySearch(Request $request)
    {
        $request->validate(['search' => 'required']);

        $item = $request->search;
        $sState = $request->state;
        $sType = $request->ptype_id;

        $property = Property::where('property_name', 'like', '%' . $item . '%')
            ->where('property_status', 'buy')
            ->with('type', 'pState')
            ->whereHas('pState', function ($q) use ($sState) {
                $q->where('state_name', 'like', '%' . $sState . '%');
            })
            ->whereHas('type', function ($q) use ($sType) {
                $q->where('type_name', 'like', '%' . $sType . '%');
            })
            ->paginate(4);

        return view('frontend.property.property_search', compact('property'));
    }


    public function RentPropertySearch(Request $request){

        $request->validate(['search' => 'required']);
        $item = $request->search;
        $sState = $request->state;
        $stype = $request->ptype_id;

       $property = Property::where('property_name', 'like' , '%' .$item. '%')->where('property_status','rent')->with('type','pState')
        ->whereHas('pState', function($q) use ($sState){
            $q->where('state_name','like' , '%' .$sState. '%');
        })
        ->whereHas('type', function($q) use ($stype){
            $q->where('type_name','like' , '%' .$stype. '%');
         })
        ->paginate(4);

        return view('frontend.property.property_search',compact('property'));

    }


    public function AllAgents()
    {
        $agents = User::where('status', 'active')
            ->where('role', 'agent')
            ->orderBy('id', 'DESC')
            ->paginate(9);

        return view('frontend.agent.all_agents', compact('agents'));
    }
}
