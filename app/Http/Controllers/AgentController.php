<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class AgentController extends Controller
{
    public function AgentDashboard()
    {
        return view('agent.index');
    }

    public function AgentLogin()
    {
       return view('agent.agent_login');
    }
    public function AgentRegister(Request $request)
    {
        $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|unique:users,email',
         'phone' => 'required|string|max:20',
         'password' => 'required|min:8',
        ]);
        
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => "agent",
            'status' => "inactive",
        ]);

        
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('agent.dashboard', absolute: false));
    }


    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = array(
           'message' => 'Agent Logout Successfully',
           'alert-type' => 'success'
        );

        return redirect('/agent/login')->with($notification);
    }

    public function AgentProfile()
    {
       $id = Auth::user()->id;
       $profileData = User::find($id);

       return view('agent.agent_profile_view', compact('profileData'));
    }


    public function AgentProfileStore(Request $request)
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
          @unlink(public_path('uploads/agent_images/'.$data->photo));
          $filename = date('YmdHi').$file->getClientOriginalName();
          $file->move(public_path('uploads/agent_images'), $filename);
          $data['photo'] = $filename;
       }

       $data->save();

        $notification = array(
           'message' => 'Agent Profile Updated Successfully',
           'alert-type' => 'success'
        );

       return redirect()->back()->with($notification);
     
   }

    public function AgentChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('agent.agent_change_password', compact('profileData'));
    }


    public function AgentPasswordUpdate(Request $request) 
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
}
