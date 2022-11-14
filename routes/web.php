<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('home');
// });


Route::get('/', [HomeController::class,'home'])->name('home');
Route::get('/home', [HomeController::class,'home'])->name('home');
Route::get('/books', [HomeController::class,'books'])->name('books');
Route::post('/importXMLFile', [HomeController::class,'importXMLFile'])->name('importXMLFile');
Route::get('/bookList', [HomeController::class,'bookList'])->name('bookList');
Route::post('/searchByAuthor', [HomeController::class,'searchByAuthor'])->name('searchByAuthor');

