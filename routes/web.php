<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource("posts", PostController::class);

// Route::get('/debug-check', function () {
//     return phpinfo();
// });