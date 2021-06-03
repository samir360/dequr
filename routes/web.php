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

Auth::routes();
Route::match(['get', 'post'], 'logout', 'Auth\LoginController@logout')->name('logout');
include('frontend.php');
include('backend/configuration.php');
include('backend/records.php');
include('backend/landing_page.php');