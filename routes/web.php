<?php

use App\Http\Controllers\CommentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{user}/show', function (User $user) {
    return $user;
});

Route::get('posts',[PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}',[PostController::class, 'show'])->name('posts.show');
Route::post('posts/ajaxloadpost',[PostController::class, 'ajaxloadpost'])->name('posts.ajaxloadpost');
Route::post('posts/update',[PostController::class, 'update'])->name('posts.update');


Route::post('comment',[CommentController::class,'store'])->name('comment.store');
Route::post('comment/delete',[CommentController::class,'delete'])->name('comment.delete');
