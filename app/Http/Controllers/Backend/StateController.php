<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\File;

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

    public function EditState($id){

        $state = State::findOrFail($id);
        return view('backend.state.edit_state',compact('state'));

    }

    
    public function UpdateState(Request $request, $id)
    {
        $request->validate([
            'state_name' => 'required|string|max:255',
            'state_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $state = State::findOrFail($id);

        $image = $request->file('state_image');

        // SI nouvelle image uploadée
        if ($image) {

            // supprimer ancienne image si elle existe
            if (File::exists(public_path($state->state_image))) {
                File::delete(public_path($state->state_image));
            }

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

            // update avec image
            $state->update([
                'state_name' => $request->state_name,
                'state_image' => $save_url,
            ]);

        } else {

            // update sans changer image
            $state->update([
                'state_name' => $request->state_name,
            ]);
        }

        return redirect()->route('all.state')->with([
            'message' => 'State Updated Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function DeleteState($id)
    {
        $state = State::findOrFail($id);

        // supprimer image du dossier si elle existe
        if (File::exists(public_path($state->state_image))) {
            File::delete(public_path($state->state_image));
        }

        // supprimer en base
        $state->delete();

        return redirect()->route('all.state')->with([
            'message' => 'State Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
    

}
