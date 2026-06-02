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
}
