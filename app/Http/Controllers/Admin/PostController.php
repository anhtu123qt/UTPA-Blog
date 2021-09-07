<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::paginate(4);
//        dd($posts);
        return view('admin.post',compact('categories','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::id();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if($request->hasFile('image')) {
            $images = $request->file('image');
            foreach($images as $image){
                $img = date('Y.m.d').'_'.$image->getClientOriginalName();
                $img_437x383 = '437x383_'.date('Y.m.d').'_'.$image->getClientOriginalName();
                $img_255x255 = '255x255_'.date('Y.m.d').'_'.$image->getClientOriginalName();
                $img_825x474 = '825x474_'.date('Y.m.d').'_'.$image->getClientOriginalName();
                if(!is_dir("./upload/post/$user_id")) {
                    mkdir("./upload/post/$user_id");
                }
                $path_437x383 = public_path('upload/post/'.$user_id.'/'.$img_437x383);
                $path_255x255 = public_path('upload/post/'.$user_id.'/'.$img_255x255);
                $path_825x474 = public_path('upload/post/'.$user_id.'/'.$img_825x474);
                Image::make($image->getRealPath())->resize(437, 383)->save($path_437x383);
                Image::make($image->getRealPath())->resize(255, 255)->save($path_255x255);
                Image::make($image->getRealPath())->resize(825, 474)->save($path_825x474);
                $imgs[] = $img;
            }
        }
        Post::create([
            'user_id' => $user_id,
            'category_id' => $data['category'],
            'post_title' => $data['name'],
            'post_description' => $data['desc'],
            'post_content' => $data['content'],
            'post_image' => json_encode($imgs),
            'post_slug' => $data['slug'],
            'post_status' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'published_at' => null
        ]);
        return redirect()->back()->with('success','Thêm bài viết thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
    public function check_status_post(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if($data['status'] == 1){
            $post = Post::where('id',$data['id'])->update(['post_status'=>$data['status'],'published_at'=>$now]);
        }else {
            $post = Post::where('id',$data['id'])->update(['post_status'=>$data['status'],'published_at'=>null]);
        }

    }
}
