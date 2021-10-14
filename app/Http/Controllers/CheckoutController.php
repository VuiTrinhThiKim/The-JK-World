<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Redirect;
use Hash;
use Cart;

session_start();
class CheckoutController extends Controller
{
    public function checkout_login() {

	    $category_list = Category::orderby('category_name', 'asc')->get();
	    $brand_list = Brand::orderby('brand_name', 'asc')->get();

	    return view('page.checkout.checkout_login_view')
	            ->with('category_list', $category_list)->with('brand_list', $brand_list);
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
        $shipping->is_default = $request->get('isDefault');
        
        $shipping->save();
        $current_shipping_id = $shipping->shipping_id;
        $shipping_detail = Shipping::where('shipping_id', $current_shipping_id)->get();
        //dd($current_shipping_id);
        Session::put('shipping_id', $current_shipping_id);
        Session::put('shipping_detail', $shipping_detail);

        return Redirect::to('/thanh-toan');
    }

    public function payment(){

        return view('page.checkout.preview_payment');
    }

    public function order(Request $request) {

        $order  = new Order();

        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $order->payment_id = $request->get('paymentMethod');
        $order->order_total = Cart::total();
        $order->order_status = 'Chờ xử lí';
        $order->order_paid = $request->get('orderPaid');
        $order->order_note = $request->get('orderNote');
        //dd($request->get('paymentMethod'));
        $order->save();

        
        $cart_content = Cart::content();
        foreach ($cart_content as $key => $cart_item) {

            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->order_id;
            $order_detail->product_id = $cart_item->id;
            $order_detail->product_name = $cart_item->name;
            $order_detail->product_price = $cart_item->price;
            $order_detail->product_sale_qty = $cart_item->qty;

            $order_detail->save();
        }
        switch ($request->get('paymentMethod')) {
            case 1:
                //echo 'Thanh toán khi nhận hàng';
                $category_list = Category::orderby('category_name', 'asc')->get();
                $brand_list = Brand::orderby('brand_name', 'asc')->get();
                $customer_name = Customer::where('customer_id', $order->customer_id)->value('username');
                Cart::destroy();
                return view('page.checkout.thanks_view')
                        ->with('category_list', $category_list)
                        ->with('brand_list', $brand_list)
                        ->with('customer_name', $customer_name)
                        ->with('order_id', $order->order_id);
                break;
            case 2:
                echo 'Thanh toán bằng thẻ ATM';
                break;
            case 3:
                echo 'Thanh toán bằng thẻ ghi nợ nội địa';
                break;
            default:
                echo 'default';
                break;
        }
    }
}
