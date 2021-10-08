<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // rmdir('storage/app/public/attachment/tmp/61607141c15a9-1633710401');
    return view('register');
});

Route::post('/upload', [\App\Http\Controllers\UploadController::class, 'store']);
Route::post('/register', [\App\Http\Controllers\UploadController::class, 'register']);
