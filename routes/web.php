<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['prefix'=> '/','middleware'=>['auth']], function () {
    Route::get('/home', [BlogController::class, 'index'])->name('home');
    Route::get('/getData',[BlogController::class,'show'])->name('blog.getData');
    Route::post('/', [BlogController::class,'store'])->name('blogs.add');
    Route::get('/{id}',[BlogController::class,'edit'])->name('blogs.getbyid');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('blogs.delete');
});


