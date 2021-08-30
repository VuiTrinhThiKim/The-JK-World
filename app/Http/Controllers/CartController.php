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
