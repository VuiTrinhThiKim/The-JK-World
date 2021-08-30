<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Shipping;
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

    

    public function save_shipping(Request $request, Shipping $shipping){

        $shipping = new Shipping();

        $shipping->customer_name = $request->customerFullName;
        $shipping->customer_email = $request->customerEmail;
        $shipping->customer_phone = $request->customerPhone;
        $shipping->shipping_address = $request->customerAddress;
        $shipping->shipping_note = $request->customerNote;

        $shipping->save();
        $current_shipping_id = $shipping->shipping_id();

        Session::put('shipping_id', $current_shipping_id);

        return Redirect::to('/payment');
    }
}
