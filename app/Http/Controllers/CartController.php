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
        return Redirect::to('/xem-gio-hang');
    }

    
    public function show_cart()
    {
        
        return view('page.cart.cart_view');
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
    public function update_quantity(Request $request, Cart $cart, $rowId)
    {
        $qty = $request->itemQuantity;
        Cart::update($rowId, $qty);

        return Redirect::to('/xem-gio-hang');
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
        
        return Redirect::to('/xem-gio-hang');
    }

    public function destroy($cartId)
    {
        //
    }

}
