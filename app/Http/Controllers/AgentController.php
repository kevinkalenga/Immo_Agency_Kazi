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
}
