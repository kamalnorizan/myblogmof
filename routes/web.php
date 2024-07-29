<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{user}/show', function (User $user) {
    return $user;
});


