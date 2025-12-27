<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

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

        return redirect('/admin/login');
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
   
}
