<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Hash;
use Redirect;
use Session;

session_start();
class CustomerController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        //$customer_name = $request->get('firstName').' '.$request->get('lastName');;
        //dd($customer_name);

        Session::put('customer_id', $customer->customer_id);
        Session::put('username', $customer->username);
        return Redirect::to('/thanh-toan');
    }

    public function login(Request $request){

        $username = $request->username;
        $password = $request->password;
        $result = Customer::where('username', $username)->first();
        
        if($result) {
            $hashedPassword = $result->password;
            if (Hash::check($password, $hashedPassword)) {

                Session::put('username', $username);
                Session::put('customer_id', $result->customer_id);
                return Redirect::to('/');
            }
            else {
                Session::put('messCustomer', 'Sai mật khẩu');
                return Redirect::to('/login-to-checkout');
            }
        }
        Session::put('messCustomer', 'Sai tên đăng nhập');
        return Redirect::to('/login-to-checkout');
    }
    public function logout(){

        Session::forget('customer_id');
        Session::forget('username');

        return Redirect::to('/');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
