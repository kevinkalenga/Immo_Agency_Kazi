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
use App\Models\Comment;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\File;

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


    public function EditPost($id)
    {
        $blogCat = BlogCategory::latest()->get(); 
        $post = BlogPost::findOrFail($id);
        return view('backend.post.edit_post', compact('post', 'blogCat'));

    }


    public function UpdatePost(Request $request, $id)
    {
       

        $blogPost = BlogPost::findOrFail($id);

        $image = $request->file('post_image');

        // SI nouvelle image uploadée
        if ($image) {

            // supprimer ancienne image si elle existe
            if (File::exists(public_path($blogPost->post_image))) {
                File::delete(public_path($blogPost->post_image));
            }

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

            // update avec image
            $blogPost->update([
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

        } else {

            // update sans changer image
            $blogPost->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('all.post')->with([
            'message' => 'BlogPost Updated Successfully',
            'alert-type' => 'success'
        ]);
    }


    public function DeletePost($id)
    {
        $blogPost = BlogPost::findOrFail($id);

        // supprimer image du dossier si elle existe
        if (File::exists(public_path($blogPost->post_image))) {
            File::delete(public_path($blogPost->post_image));
        }

        // supprimer en base
        $blogPost->delete();

        return redirect()->route('all.post')->with([
            'message' => 'BlogPost Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
    public function BlogDetails($slug)
    {
       $blog = BlogPost::where('post_slug', $slug)->first();

       $tags = $blog->post_tags;
       $tags_all = explode(',',$tags);

       $bCategory = BlogCategory::latest()->get();
       
       $dPost = BlogPost::latest()->limit(3)->get();

       return view('frontend.blog.blog_details', compact('blog', 'tags_all', 'bCategory', 'dPost'));
    }
    public function BlogCatList($id)
    {
       $blog = BlogPost::where('blogcat_id', $id)->paginate(4);

       $breadCat = BlogCategory::where('id', $id)->first();

       $bCategory = BlogCategory::latest()->get();
       
       $dPost = BlogPost::latest()->limit(3)->get();

       return view('frontend.blog.blog_cat_list', compact('blog', 'breadCat', 'bCategory', 'dPost'));
    }
    public function BlogList()
    {
       $blog = BlogPost::latest()->paginate(4);


       $bCategory = BlogCategory::latest()->get();
       
       $dPost = BlogPost::latest()->limit(3)->get();

       return view('frontend.blog.blog_list', compact('blog', 'bCategory', 'dPost'));
    }

    public function StoreComment(Request $request) 
    {
        $pId = $request->post_id;

        Comment::insert([
            'user_id' => Auth::user()->id,
            'post_id' => $pId,
            'parent_id' => null,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with([
            'message' => 'Comment Added Successfully',
            'alert-type' => 'success'
        ]);
        
    }

    public function AdminBlogComment() 
    {
        $comment = Comment::where('parent_id', null)->latest()->get();

        return view('backend.comment.comment_all', compact('comment'));
    }
    
    public function AdminCommentReply($id) 
    {
        $comment = Comment::where('id', $id)->first();

        return view('backend.comment.comment_reply', compact('comment'));
    }


     public function ReplyMessage(Request $request){

        $id = $request->id;
        $user_id = $request->user_id;
        $post_id = $request->post_id;

        Comment::insert([
            'user_id' => $user_id,
            'post_id' => $post_id,
            'parent_id' => $id,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),

        ]);

          $notification = array(
            'message' => 'Reply Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    }

}
