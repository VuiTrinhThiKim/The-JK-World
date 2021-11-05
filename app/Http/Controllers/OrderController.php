<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Redirect;
use Cart;
use Mail;

class OrderController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function loginAuthentication() {
        $ad_username = Session::get('ad_username');

        if($ad_username){
            return Redirect::to('admin_login_view');
        }
        else {
            return Redirect::to('admin')->send('Vui lòng đăng nhập');
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$order = Order::
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view_all(){

        $this->loginAuthentication();

        $orders = Order::join('customers', 'customers.customer_id', '=', 'orders.customer_id')
                        ->join('shipping', 'shipping.shipping_id', '=', 'orders.shipping_id')
                        ->join('payment', 'payment.payment_id', '=', 'orders.payment_id')
                        ->join('status', 'status.status_id', '=', 'orders.status_id')
                        ->orderbyDesc('orders.order_id')
                        ->paginate(5);
        //dd($brands->links());
        $count_order = Order::count();
        $manager_order = view('admin.order.all_orders_view')->with('orders', $orders);

        return view('admin_layout_view')->with('admin.order.all_orders_view', $manager_order);
    }

    public function pendding_orders(){
        $this->loginAuthentication();

        $orders = Order::join('customers', 'customers.customer_id', '=', 'orders.customer_id')
                        ->join('shipping', 'shipping.shipping_id', '=', 'orders.shipping_id')
                        ->join('payment', 'payment.payment_id', '=', 'orders.payment_id')
                        ->join('status', 'status.status_id', '=', 'orders.status_id')
                        ->where('orders.status_id', 1)
                        ->orderbyDesc('orders.order_id')
                        ->paginate(5);
        //dd($brands->links());
        $count_order = Order::count();
        $manager_order = view('admin.order.pendding_orders_view')->with('orders', $orders);

        return view('admin_layout_view')->with('admin.order.pendding_orders_view', $manager_order);
    }

    public function confirm($order_id) {
        $order = Order::where('order_id')->get();

        
    }
    //Customer order
    public function order(Request $request) {

        $order  = new Order();

        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $order->payment_id = $request->get('paymentMethod');
        $order->order_total = (int) str_replace(',', '', Cart::total());
        $order->status_id = 1;
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
            $order_detail->product_price = (int) str_replace(',', '', $cart_item->price);
            $order_detail->product_sale_qty = $cart_item->qty;

            $order_detail->save();
        }

        //$this->send_mail_to_confirm_order($order->order_id, $order->customer_id);

        switch ($request->get('paymentMethod')) {
            case 1:
                //echo 'Thanh toán khi nhận hàng';
                $customer_name = Customer::where('customer_id', $order->customer_id)->value('username');
                Cart::destroy();
                return view('page.checkout.thanks_view')->with('customer_name', $customer_name)
                                                        ->with('order_id', $order->order_id);
                break;
            case 2:
                $customer_name = Customer::where('customer_id', $order->customer_id)->value('username');
                Cart::destroy();
                return view('page.checkout.thanks_view')->with('customer_name', $customer_name)
                                                        ->with('order_id', $order->order_id);
                break;
            case 3:
                $customer_name = Customer::where('customer_id', $order->customer_id)->value('username');
                Cart::destroy();
                return view('page.checkout.thanks_view')->with('customer_name', $customer_name)
                                                        ->with('order_id', $order->order_id);
                break;
            default:
                echo 'default';
                break;
        }
    }
    /**
    public function send_mail_to_confirm_order($order_id, $shipping_id) {

        $shipping_detail = Shipping::where('shipping_id', $shipping_id);

        $to_name = $shipping_detail->value('customer_name');
        $to_email = Customer::where('customer_id', $shipping_detail->value('customer_id'))->value('email');

    }
    **/
}
