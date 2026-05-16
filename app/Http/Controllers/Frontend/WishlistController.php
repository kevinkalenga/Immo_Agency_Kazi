<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Wishlist;
use App\Models\User;
use Carbon\Carbon;
use Auth;


class WishlistController extends Controller
{
    public function AddToWishlist(Request $request, $property_id)
    {
        if(Auth::check()) {
         $exists = Wishlist::where('user_id', Auth::id())->where('property_id', $property_id)->first();

            if(!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now()
                ]);

                return response()->json(['success' => 'Property has been added in you wishlist']);
            } else {
                return response()->json(['error' => 'Property has already been added in you wishlist']);
            }
        } else {
            return response()->json(['error' => 'You must be login before adding the property in the wishlist']);
        }
    }

    public function UserWishlist()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);

        return view('frontend.dashboard.wishlist', compact('userData'));
    }
    public function GetWishlistProperty()
    {
        
       $wishlist = Wishlist::with('property')->where('user_id', Auth::id())->latest()->get();

       $wishQty = Wishlist::where('user_id', Auth::id())->count();

       return response()->json(['wishlist' => $wishlist, 'wishQty' => $wishQty]);
    }
}
