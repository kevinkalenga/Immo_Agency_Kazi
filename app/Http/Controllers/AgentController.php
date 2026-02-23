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
        return view('agent.agent_dashboard');
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
}
