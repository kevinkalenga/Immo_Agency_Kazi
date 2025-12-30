<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }
    public function UserProfile()
    {
        $id = Auth::user()->id;
        $userData = User::find($id);

        return view('frontend.dashboard.edit_profile', compact('userData'));
    }
}
