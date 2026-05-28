<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StateController extends Controller
{
    public function AllState()
    {
        $states = State::latest()->get();

        return view('backend.state.all_state', compact('states'));
    }

    public function AddState()
    {
       return view('backend.state.add_state');
    }

    public function StoreState(Request $request)
    {
        $request->validate([
            'state_name' => 'required|string|max:255',
            'state_image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $image = $request->file('state_image');

        // Intervention Image v3
        $manager = new ImageManager(new Driver());

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $image_resized = $manager->read($image)
            ->resize(370, 275);

        $path = public_path('uploads/state/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image_resized->save($path . $name_gen);

        $save_url = 'uploads/state/' . $name_gen;

        State::insert([
            'state_name' => $request->state_name,
            'state_image' => $save_url,
        ]);

        return redirect()->route('all.state')->with([
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success'
        ]);
    }

}
