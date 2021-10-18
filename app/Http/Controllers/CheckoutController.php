<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Redirect;
use Hash;
use Cart;
use Mail;

session_start();
class CheckoutController extends Controller
{
    public function checkout_login() {

	    return view('page.checkout.checkout_login_view');
    }

    public function create_shipping($customer_id) {

        $shipping_default = Shipping::where('customer_id', $customer_id)->where('is_default', '1')->get();
        $shipping_not_default = Shipping::where('customer_id', $customer_id)->where('is_default', '0')->get();

	    return view('page.checkout.shipping_view')->with('shipping_default', $shipping_default)
                                                ->with('shipping_not_default', $shipping_not_default);
    }

    public function chosse_shipping_by_id(Request $request) {

        $current_shipping_id = $request->get('shippingIdSelected');      
        $shipping_detail = Shipping::where('shipping_id', $current_shipping_id)->get();

        Session::put('shipping_id', $current_shipping_id);
        Session::put('shipping_detail', $shipping_detail);
        return Redirect::to('/thanh-toan');
    }

    public function save_shipping(Request $request) {

        $shipping = new Shipping();

        $shipping->customer_id = $request->get('customerId');
        $shipping->customer_name = $request->get('customerFullName');
        $shipping->customer_email = $request->get('customerEmail');
        $shipping->customer_phone = $request->get('customerPhone');
        $shipping->shipping_address = $request->get('customerAddress');

        if(Shipping::where('customer_id', $shipping->customer_id)->where('is_default', '1')->first() != null) {

            $shipping->is_default = $request->get('isDefault');
        }
        else {

            $shipping->is_default = 1;
        }
        
        $shipping->save();
        $current_shipping_id = $shipping->shipping_id;
        $shipping_detail = Shipping::where('shipping_id', $current_shipping_id)->get();
        //dd($current_shipping_id);
        Session::put('shipping_id', $current_shipping_id);
        Session::put('shipping_detail', $shipping_detail);

        return Redirect::to('/thanh-toan');
    }

    public function payment(){

        $payment_methods_available = Payment::where('payment_status' ,'=', 1)->get();

        return view('page.checkout.preview_payment')->with('payment_methods',$payment_methods_available);
    }
}
