<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function AllState()
    {
        $states = State::latest()->get();

        return view('backend.state.all_state', compact('states'));
    }
}
