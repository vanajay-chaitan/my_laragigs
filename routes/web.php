<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

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
//All Listings
Route::get('/', [ListingController :: class,'index']);

//show create form
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//store listing  data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

//show edit form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

//Single Listing
Route::get('/listings/{listing}',[ListingController::class,'show']);

//show register/create form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//create user
Route::Post('/users',[UserController::class,'store']);

//Log user out
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//Login Form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Log In User
Route::post('/users/authenticate',[UserController::class,'authenticate']);


















//Route::get('/hello',function(){
//    return response('<h1> Hello World </h1>');
//});
//Route::get('/posts/{id}',function($id){
//    return response('Posts ' . $id);
//})->where('id','[0-9]+');
//Route::get('/search',function(Request $request){
//    return $request->name .' '. $request->city;
//});
