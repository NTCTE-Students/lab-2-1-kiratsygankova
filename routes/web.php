<?php

   use App\Http\Controllers\ArticleController;
   use App\Http\Controllers\CategoryController;
   use Illuminate\Support\Facades\Route;

   Route::get('/', function () {
       return view('welcome');
   });

   Auth::routes();

   Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

   Route::resource('articles', ArticleController::class);
   Route::resource('categories', CategoryController::class);
