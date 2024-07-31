<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::select('id','uuid','title','content','author')->with(['user'=>function($q){
            $q->select('id','name','email');
        },'comments'=>function($q){
            $q->select('post_id','content','uuid','user_id');
        },'comments.user'=>function($q){
            $q->select('id','name');
        }])->get();


        // $posts = Post::whereHas('comments')->get();

        // $posts = Post::with(['comments'=>function($query){
        //     $query->where('user_id',3);
        // }])->whereHas('comments',function($query){
        //     $query->where('user_id',3)->where('id','>','7');
        // })->get();
        // dd($posts);
        // $posts = Post::whereDoesntHave('comments')->count();
        // dd($posts);
        // 57498
        // return response()->json($posts);
        // dd($posts->first());
        $users = User::pluck('name','id');
        return view('posts.index', compact('posts','users'));
        // return view('posts.comment', compact('posts'));

    }

    function ajaxloadpost(Request $request) {
        try {
            $post = Post::where('uuid',$request->uuid)->first();
        } catch (\Throwable $th) {
            abort(404);
        }

        return response()->json($post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $users = User::pluck('name','id');
        // dd($users);
        $post = $post->load('user.posts','comments.user.posts');
        return view('posts.show',compact('post','users'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'content' => 'required|min:10'
        ],[
            'title.required' => 'Sila masukkan tajuk',
            'author.required' => 'Sila pilih penulis',
            'content.required' => 'Sila masukkan kandungan',
            'content.min' => 'Kandungan mesti sekurang-kurangnya 10 aksara'
        ]);

        $post = Post::where('uuid',$request->uuid)->first();
        $post->title = $request->title;
        $post->author = $request->author;
        $post->content = $request->content;
        $post->save();

        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
