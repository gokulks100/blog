<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontBlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login',[AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  Route::get('blogs',[FrontBlogController::class,'getBlogs'])->name("blogs");
});
