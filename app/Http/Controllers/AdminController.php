<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = array(
           'message' => 'Admin Logout Successfully',
           'alert-type' => 'success'
        );

        return redirect('/admin/login')->with($notification);
    }
    public function AdminLogin()
    {
       return view('admin.admin_login');
    }
    public function AdminProfile()
    {
        // to check the user who is logged in and access by the id
       $id = Auth::user()->id;
       $profileData = User::find($id);

       return view('admin.admin_profile_view', compact('profileData'));
    }


    public function AdminProfileStore(Request $request)
    {
       $id = Auth::user()->id;
       $data = User::find($id);
       $data->name = $request->name;
       $data->username = $request->username;
       $data->email = $request->email;
       $data->phone = $request->phone;
       $data->address = $request->address;

       if($request->file('photo')) {
          $file = $request->file('photo');
        //   to remove an existing img before downloading
          @unlink(public_path('uploads/admin_images/'.$data->photo));
          $filename = date('YmdHi').$file->getClientOriginalName();
          $file->move(public_path('uploads/admin_images'), $filename);
          $data['photo'] = $filename;
       }

       $data->save();

        $notification = array(
           'message' => 'Admin Profile Updated Successfully',
           'alert-type' => 'success'
        );

       return redirect()->back()->with($notification);
     
    }


    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }



    public function AdminPasswordUpdate(Request $request) 
    {
        // validation
       $request->validate([
          'old_password' => 'required',
          'new_password' => 'required|confirmed',
          
       ]);
        
      // check that old pwd and the new authenticated pwd match(l'ancien mdp est erronnée)   
       if(!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
              'message' => 'Old Password Does not Match!',
              'alert-type' => 'error'
            );

          return back()->with($notification);
    
    
        }

        // Update the new pwd 
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
           'message' => 'Your Password Is Updated Successfully',
           'alert-type' => 'success'
        );

       return back()->with($notification);
   }

   /////////////// Agent User All Method /////////
   public function AllAgent()
   {
        $allAgent = User::where('role', 'agent')->get();
        return view('backend.agentUser.all_agent', compact('allAgent'));
   }
   public function AddAgent()
   {
        return view('backend.agentUser.add_agent'); 
   }


   public function StoreAgent(Request $request)
   {

      User::insert([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'password' => Hash::make($request->password),
        'role' => 'agent',
        'status' => 'active', 
       ]);


       $notification = array(
            'message' => 'Agent Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification); 


    }


    public function EditAgent($id){

    $allAgent = User::findOrFail($id);
    return view('backend.agentUser.edit_agent',compact('allAgent'));

  }// End Method 


    public function UpdateAgent(Request $request)
    {

      $user_id = $request->id;

      User::findOrFail($user_id)->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address, 
      ]);


       $notification = array(
            'message' => 'Agent Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.agent')->with($notification);  

    }


    public function DeleteAgent($id)
    {

       User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Agent Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }

    public function changeStatus(Request $request){

      $user = User::find($request->user_id);
      $user->status = $request->status;
      $user->save();

      return response()->json(['success'=>'Status Change Successfully']);

    }

   
}
