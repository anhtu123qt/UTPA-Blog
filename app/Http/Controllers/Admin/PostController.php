<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        dd($posts);
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
            $image = $request->file('image');
            $img = current(explode('.',$image->getClientOriginalName()));
            $img1 = time().'.'.$img.'.'.$image->getClientOriginalExtension();
            $image->move('upload/post',$img1);
            $data['image'] = $img1;
        }
        Post::create([
            'user_id' => $user_id,
            'category_id' => $data['category'],
            'post_title' => $data['name'],
            'post_description' => $data['desc'],
            'post_content' => $data['content'],
            'post_image' => $data['image'],
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
