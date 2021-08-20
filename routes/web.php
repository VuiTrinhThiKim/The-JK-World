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
//Web page
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/danh-muc/{category_id}', 'CategoryController@show_category');
Route::get('/thuong-hieu/{brand_id}', 'BrandController@show_brand');
Route::get('/chi-tiet-san-pham/{product_id}', 'ProductController@show_product_detail');

//Admin page
Route::prefix('admin')->group(function(){

	//Show Login Admin Panel
	Route::get('/', 'AdminController@index');
	//Show Admin Panel
	Route::get('/dashboard', 'AdminController@showDashboard');
	//Login to dashboard
	Route::post('/admin-dashboard', 'AdminController@dashboard');
	//Admin Logout
	Route::get('/logout', 'AdminController@logout');

	Route::group(['prefix'=>'category'], function(){
		//All Categories
		Route::get('/view-all', 'CategoryController@view_all');
		//Add Category
		Route::get('/add', 'CategoryController@add');

		//Category Status
		Route::get('/public-category/{category_id}', 'CategoryController@update_category_status');
		Route::get('/unpublic-category/{category_id}', 'CategoryController@update_category_status');
		//Edit Category
		Route::get('/edit/{category_id}', 'CategoryController@edit');
		//Update Category
		Route::post('/update/{category_id}', 'CategoryController@update');
		//Delete Category
		Route::get('/delete/{category_id}', 'CategoryController@delete');
		//Save Category
		Route::post('/save', 'CategoryController@save');

	});

	Route::group(['prefix'=>'brand'], function(){
		//All Brands
		Route::get('/view-all', 'BrandController@view_all');
		//Add Brand
		Route::get('/add', 'BrandController@add');

		//Brand Status
		Route::get('/public-brand/{brand_id}', 'BrandController@update_brand_status');
		Route::get('/unpublic-brand/{brand_id}', 'BrandController@update_brand_status');
		//Edit Brand
		Route::get('/edit/{brand_id}', 'BrandController@edit');
		//Update Brand
		Route::post('/update/{brand_id}', 'BrandController@update');
		//Delete Brand
		Route::get('/delete/{brand_id}', 'BrandController@delete');
		//Save Brand
		Route::post('/save', 'BrandController@save');

	});

	Route::group(['prefix'=>'product'], function(){
		//All Brands
		Route::get('/view-all', 'ProductController@view_all');
		//Add Brand
		Route::get('/add', 'ProductController@add');

		//Brand Status
		Route::get('/public-product/{product_id}', 'ProductController@update_product_status');
		Route::get('/unpublic-product/{product_id}', 'ProductController@update_product_status');
		//Edit Brand
		Route::get('/edit/{product_id}', 'ProductController@edit');
		//Update Brand
		Route::post('/update/{product_id}', 'ProductController@update');
		//Delete Brand
		Route::get('/delete/{product_id}', 'ProductController@delete');
		//Save Brand
		Route::post('/save', 'ProductController@save');

	});
});

