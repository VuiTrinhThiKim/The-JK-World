<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Session;
use Redirect;
use Hash;

session_start();
class CheckoutController extends Controller
{
    public function checkout_login(){

	    $category_list = Category::orderby('category_name', 'asc')->get();
	    $brand_list = Brand::orderby('brand_name', 'asc')->get();

	    return view('page.checkout.checkout_login_view')
	            ->with('category_list', $category_list)->with('brand_list', $brand_list);
    }

    public function checkout(){

	    $category_list = Category::orderby('category_name', 'asc')->get();
	    $brand_list = Brand::orderby('brand_name', 'asc')->get();

	    return view('page.checkout.checkout_view')
	            ->with('category_list', $category_list)->with('brand_list', $brand_list);
    }

    public function create_customer(Request $request){

    	$customer = new Customer;

        $hash_pass = Hash::make($request->get('password'));

        $customer->username = $request->get('username');
        $customer->password= $hash_pass;
        $customer->first_name = $request->get('firstName');
        $customer->last_name = $request->get('lastName');
        $customer->phone = $request->get('customerPhone');
        $customer->email = $request->get('customerEmail');

        if(Customer::where('username',$customer->username)->first() != null) {
            Session::put('messCustomer','Lỗi: Tên đăng nhập đã được sử dụng!!!');
            return Redirect::to('/login-to-checkout');
        }
        if(Customer::where('phone',$customer->phone)->first() != null) {
            Session::put('messCustomer','Lỗi: Số điện thoại đã được sử dụng!!!');
            return Redirect::to('/login-to-checkout');
        }
        if(Customer::where('email',$customer->email)->first() != null) {
            Session::put('messCustomer','Lỗi: Email đã được sử dụng!!!');
            return Redirect::to('/login-to-checkout');
        }
        $customer->save();
        Session::put('messCustomer','Tạo tài khoản thành công');
        // Put customer_id
        $customer_name = $request->get('firstName').' '.$request->get('lastName');;
        dd($customer_name);
        Session::put('customer_id', $customer->customer_id());
        Session::put('customer_name', $customer_name);
        return Redirect::to('/thanh-toan');
    }
}
