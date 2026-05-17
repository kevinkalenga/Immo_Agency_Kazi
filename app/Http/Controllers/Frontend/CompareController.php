<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compare;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class CompareController extends Controller
{
    public function AddToCompare(Request $request, $property_id)
    {
        if(Auth::check()) {
            // When this will match
         $exists = Compare::where('user_id', Auth::id())->where('property_id', $property_id)->first();

            if(!$exists) {
                Compare::insert([
                    'user_id' => Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now()
                ]);

                return response()->json(['success' => 'Property has been added in your compare list']);
            } else {
                return response()->json(['error' => 'Property has already been added in your compare list']);
            }
        } else {
            return response()->json(['error' => 'You must be login before adding the property your compare list']);
        }
    }

    public function UserCompare()
    {
       return view('frontend.dashboard.compare');
    }
    public function GetCompareProperty()
    {
      
        $compare = Compare::with('property')->where('user_id', Auth::id())->latest()->get();

      

       return response()->json($compare);

    }

    public function CompareRemove($id){

      Compare::where('user_id',Auth::id())->where('id',$id)->delete();
      return response()->json(['success' => 'Successfully Property Remove']);

    }
}
