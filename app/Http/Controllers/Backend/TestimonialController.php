<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\File;


class TestimonialController extends Controller
{
    public function AllTestimonials()
    {
        $testimonials = Testimonial::latest()->get();

        return view('backend.testimonial.all_testimonial', compact('testimonials'));
    }

    public function AddTestimonials()
    {
       return view('backend.testimonial.add_testimonial');
    }
    public function StoreTestimonials(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
             'message' => 'required|string',
        ]);

        $image = $request->file('image');

        // Intervention Image v3
        $manager = new ImageManager(new Driver());

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $image_resized = $manager->read($image)
            ->resize(100, 100);

        $path = public_path('uploads/testimonial/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image_resized->save($path . $name_gen);

        $save_url = 'uploads/testimonial/' . $name_gen;

        Testimonial::insert([
            'name' => $request->name,
            'position' => $request->position,
            'image' => $save_url,
            'message' => $request->message,
        ]);

        return redirect()->route('all.testimonials')->with([
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        ]);
    }
}
