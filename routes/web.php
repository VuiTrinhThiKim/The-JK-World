<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;


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
Route::get('/test', [ProductController::class, 'show_Brand']);
//Web page
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);

Route::get('/danh-muc/{category_slug}', [CategoryController::class, 'show_category']);
Route::get('/thuong-hieu/{brand_slug}', [BrandController::class, 'show_brand']);
Route::get('/chi-tiet-san-pham/{product_slug}', [ProductController::class, 'show_product_detail']);
//Cart
Route::post('/gio-hang', [CartController::class, 'index']);
Route::get('/xem-gio-hang', [CartController::class, 'show_cart']);
Route::get('/xoa-san-pham-khoi-gio-hang/{cardId}', [CartController::class, 'delete_to_cart']);
Route::post('/cap-nhat-so-luong/{cardId}', [CartController::class, 'update_quantity']);
//Route::get('/gio-hang', [CartController::class, 'cart_ajax']);
//Route::post('/add-to-cart-ajax',[CartController::class, 'add_to_cart_ajax']);

Route::get('/tim-kiem', [HomeController::class, 'search']);
Route::get('/lien-he', [ContactUsController::class, 'index']);

Route::get('/login-to-checkout', [CheckoutController::class, 'checkout_login']);
Route::get('/thong-tin-giao-hang/{customer_id}', [CheckoutController::class, 'create_shipping']);
Route::post('/chon-dia-chi-giao-hang', [CheckoutController::class, 'chosse_shipping_by_id']);
Route::post('/luu-thong-tin-giao-hang', [CheckoutController::class, 'save_shipping']);
Route::get('/thanh-toan', [CheckoutController::class, 'payment']);
Route::post('/dat-hang', [OrderController::class, 'order']);

Route::post('/tao-tai-khoan', [CustomerController::class, 'create_customer']);
Route::post('/dang-nhap', [CustomerController::class, 'login']);
Route::get('/dang-xuat', [CustomerController::class, 'logout']);

Route::get('/tai-khoan/{customer_id}', [CustomerController::class, 'show_info']);
//Admin page
Route::prefix('admin')->group(function(){

	//Show Login Admin Panel
	Route::get('/', [AdminController::class, 'index']);
	//Show Admin Panel
	Route::get('/dashboard', [AdminController::class, 'showDashboard']);
	//Login to dashboard
	Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
	//Admin Logout
	Route::get('/logout', [AdminController::class, 'logout']);
	//Show Add New Addmin Account
	Route::get('/create', [AdminController::class, 'showCreate']);
	Route::group(['prefix'=>'category'], function(){
		//All Categories
		Route::get('/view-all', [CategoryController::class, 'view_all']);
		//Create Category
		Route::get('/add', [CategoryController::class, 'create']);
		//Add to db
		Route::post('/add', [CategoryController::class, 'store']);
		//Category Status
		Route::get('/public-category/{category_id}', [CategoryController::class, 'update_category_status']);
		Route::get('/unpublic-category/{category_id}', [CategoryController::class, 'update_category_status']);
		//Edit Category
		Route::get('/edit/{category_id}', [CategoryController::class, 'edit']);
		//Update Category
		Route::post('/update/{category_id}', [CategoryController::class, 'update']);
		//Delete Category
		Route::get('/delete/{category_id}', [CategoryController::class, 'destroy']);
		//Search Category
		Route::get('/search', [CategoryController::class, 'search']);
		//Filter Category
		Route::get('/filter', [CategoryController::class, 'filter']);
	});

	Route::group(['prefix'=>'brand'], function(){
		//All Brands
		Route::get('/view-all', [BrandController::class, 'view_all']);
		//Create Brand
		Route::get('/add', [BrandController::class, 'create']);
		//Add to db
		Route::post('/add', [BrandController::class, 'store']);
		//Brand Status
		Route::get('/public-brand/{brand_id}', [BrandController::class, 'update_brand_status']);
		Route::get('/unpublic-brand/{brand_id}', [BrandController::class, 'update_brand_status']);
		//Edit Brand
		Route::get('/edit/{brand_id}', [BrandController::class, 'edit']);
		//Update Brand
		Route::post('/update/{brand_id}', [BrandController::class, 'update']);
		//Delete Brand
		Route::get('/delete/{brand_id}', [BrandController::class, 'destroy']);
		//Search Brand
		Route::get('/search', [BrandController::class, 'search']);
		//Filter Brand
		Route::get('/filter', [BrandController::class, 'filter']);
	});

	Route::group(['prefix'=>'product'], function(){
		//All Product
		Route::get('/view-all', [ProductController::class, 'view_all']);
		//Add Product
		Route::get('/add', [ProductController::class, 'create']);
		//Add to db
		Route::post('/add', [ProductController::class, 'store']);
		//Product Status
		Route::get('/public-product/{product_id}', [ProductController::class, 'update_product_status']);
		Route::get('/unpublic-product/{product_id}', [ProductController::class, 'update_product_status']);
		//Edit Product
		Route::get('/edit/{product_id}', [ProductController::class, 'edit']);
		//Update Product
		Route::post('/update/{product_id}', [ProductController::class, 'update']);
		//Delete Product
		Route::get('/delete/{product_id}', [ProductController::class, 'destroy']);
		//Search Product
		Route::get('/search', [ProductController::class, 'search']);
		//Filter Product
		Route::get('/filter', [ProductController::class, 'filter']);
	});

	Route::group(['prefix'=>'member'], function(){
		//All Admin
		Route::get('/view-all', [AdminController::class, 'view_all']);
		//Add Admin
		Route::get('/add', [AdminController::class, 'create']);
		//Add to db
		Route::post('/add', [AdminController::class, 'store']);
		//Edit Admin
		Route::get('/edit/{admin_id}', [AdminController::class, 'edit']);
		//Update Admin
		Route::post('/update/{admin_id}', [AdminController::class, 'update']);
		//Delete Admin
		Route::get('/delete/{admin_id}', [AdminController::class, 'destroy']);
		//Search Product
		Route::get('/search', [AdminController::class, 'search']);
		//Filter Product
		Route::get('/filter', [AdminController::class, 'filter']);
		//Show Admin Information
		Route::get('/info/{admin_id}', [AdminController::class, 'show_info']);
		//Change Password
		Route::get('/change-password/{admin_id}', [AdminController::class, 'show_change_password']);
		Route::post('/change-password/{admin_id}', [AdminController::class, 'change_password']);
	});

	Route::group(['prefix'=>'customer'], function(){
		//All Customer
		Route::get('/view-all', [CustomerController::class, 'view_all']);
		//Add Customer
		//Route::get('/add', [CustomerController::class, 'create']);
	});

	Route::group(['prefix'=>'order'], function(){
		//All Order
		Route::get('/view-all', [OrderController::class, 'view_all']);

		Route::get('/pendding', [OrderController::class, 'pendding_orders']);
		//Add Admin
		//Route::get('/add', [AdminController::class, 'create']);
	});
});
