<?php

use App\Http\Controllers\CategoryController;
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

Route::get('/', [CategoryController::class, 'home'])->name('home');
Route::get('/articles/{category}', [CategoryController::class, 'articles'])->name('articles');
Route::get('/article/{article}', [CategoryController::class, 'article'])->name('article');
