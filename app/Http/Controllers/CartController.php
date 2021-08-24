<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Session;
use Redirect;
use Cart;

session_start();
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $product_id = $request->get('productId');
        $product_quantity = $request->get('productQuantity');

        $product = Product::where('product_id', $product_id)->first();

        $data = array();
        $data['id'] = $product->product_id;
        $data['qty'] = $product_quantity;
        $data['name'] = $product->product_name;
        $data['price'] = $product->price;
        $data['weight'] = $product->weight;
        $data['options']['image'] = $product->product_image;

        Cart::add($data);
        return Redirect::to('/gio-hang');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show_cart()
    {
        $category_list = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();
        $product_list = Product::where('product_status', '1')->orderby('product_id', 'desc')->get();
        
        return view('page.cart.cart_view')->with('category_list', $category_list)
                                          ->with('brand_list', $brand_list)
                                          ->with('product_list', $product_list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function delete_to_cart($rowId)
    {
        Cart::remove($rowId);
        return Redirect::to('/gio-hang');
    }

    public function destroy($cartId)
    {
        //
    }

    public function add_to_cart_ajax(Request $request){

        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');

        if($cart==true){
            $is_avaiable = 0;

            if($is_avaiable == 0){

                $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_price' => $data['cart_product_price'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                );
                Session::put('cart',$cart);
            }
        }
        else{

            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_price' => $data['cart_product_price'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
            );
            Session::put('cart',$cart);
        }
       
        Session::save();

    } 

}
