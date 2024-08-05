<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageGalleryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('image-gallery', [ImageGalleryController::class, 'index']);
Route::post('image-gallery', [ImageGalleryController::class, 'upload']);
Route::get('image-gallery-edit/{id}', [ImageGalleryController::class, 'edit']);
Route::post('image-gallery-update', [ImageGalleryController::class, 'update']);
Route::delete('image-gallery/{id}', [ImageGalleryController::class, 'destroy']);
