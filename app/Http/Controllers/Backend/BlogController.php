<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function AllBlogCategory() 
    {
      $category = BlogCategory::latest()->get();

      return view('backend.blog.blog_category', compact('category'));
    }

    public function StoreBlogCategory(Request $request)
    {

       //Insert data in db 
       BlogCategory::insert([
         'category_name' => $request->category_name,
         'category_slug'   => Str::slug($request->category_name),
         
       ]); 

       $notification = array(
           'message' => 'Category Created Successfully',
           'alert-type' => 'success'
        );

       return redirect()->route('all.blog.category')->with($notification);
    
    }

    public function EditBlogCategory($id) 
    {
      $categories = BlogCategory::findOrFail($id);
      return response()->json($categories);
    }

}
