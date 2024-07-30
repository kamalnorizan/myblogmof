<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::select('id','title','content','author')->with(['user'=>function($q){
        //     $q->select('id','name','email');
        // },'comments'=>function($q){
        //     $q->select('post_id','content','user_id');
        // },'comments.user'=>function($q){
        //     $q->select('id','name');
        // }])->get();
        $posts = Post::withCount('comments')->get();
        // dd($posts);
        // 57498
        // return response()->json($posts);
        // dd($posts->first());
        // return view('posts.index', compact('posts'));
        return view('posts.comment', compact('posts'));

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
        //
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
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
