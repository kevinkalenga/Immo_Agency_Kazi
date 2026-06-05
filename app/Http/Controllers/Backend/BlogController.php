<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;
use Auth;

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

    public function UpdateBlogCategory(Request $request)
    {
       $cat_id = $request->cat_id;
       //Insert data in db 
       BlogCategory::findOrFail($cat_id)->update([
         'category_name' => $request->category_name,
         'category_slug'   => strtolower(str_replace(' ', '-', $request->category_name)),
         
       ]); 

       $notification = array(
           'message' => 'BlogCategory Updated Successfully',
           'alert-type' => 'success'
        );

       return redirect()->route('all.blog.category')->with($notification);
    
    }
    public function DeleteBlogCategory($id)
    {
      
       $blogCategory = BlogCategory::findOrFail($id);

       $blogCategory->delete();

       $notification = array(
           'message' => 'BlogCategory Deleted Successfully',
           'alert-type' => 'success'
        );

       return redirect()->back()->with($notification);
    
    }

    public function AllPost()
    {
      $posts = BlogPost::latest()->get();

      return view('backend.post.all_post', compact('posts'));
    }
    public function AddPost()
    {
      $blogCat = BlogCategory::latest()->get();
       return view('backend.post.add_post', compact('blogCat'));
    }

    public function StorePost(Request $request)
    {
       

        $image = $request->file('post_image');

        // Intervention Image v3
        $manager = new ImageManager(new Driver());

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        $image_resized = $manager->read($image)
            ->resize(370, 250);

        $path = public_path('uploads/post/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $image_resized->save($path . $name_gen);

        $save_url = 'uploads/post/' . $name_gen;

        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'post_image' => $save_url,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('all.post')->with([
            'message' => 'BlogPost Inserted Successfully',
            'alert-type' => 'success'
        ]);
    }

}
