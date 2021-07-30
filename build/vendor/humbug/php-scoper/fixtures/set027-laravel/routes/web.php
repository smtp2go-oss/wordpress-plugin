<?php

namespace SMTP2GOWPPlugin;

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
use SMTP2GOWPPlugin\Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
