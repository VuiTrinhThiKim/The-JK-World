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
//Web-theme
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

//Show Login Admin Panel
Route::get('/admin', 'AdminController@index');
//Show Admin Panel
Route::get('/dashboard', 'AdminController@show_dashboard');
//Login to dashboard
Route::post('/admin-dashboard', 'AdminController@dashboard');
//Admin Logout
Route::get('/admin-logout', 'AdminController@logout');

//Add Category
Route::get('/add-category', 'CategoriesController@add_category');
//All Categories
Route::get('/all-categories', 'CategoriesController@all_categories');
//Category Status
Route::get('/public-category/{category_id}', 'CategoriesController@update_category_status');
Route::get('/unpublic-category/{category_id}', 'CategoriesController@update_category_status');
//Edit Category
Route::get('/edit-category/{category_id}', 'CategoriesController@edit_category');
//Update Category
Route::post('/update-category/{category_id}', 'CategoriesController@update_category');
//Delete Category
Route::get('/delete-category/{category_id}', 'CategoriesController@delete_category');
//Save Category
Route::post('/save-category', 'CategoriesController@save_category');
