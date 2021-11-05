<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Session;

session_start();
class HomeController extends Controller
{
    public function index(){

        $product_list = Product::where('product_status', '1')->orderby('product_name', 'asc')->limit(4)->get();

        //Get category id
        $category_id = '1';

        $related_products_active = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->where('categories.category_id', $category_id)->limit(3)->get();

        $related_products = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->where('categories.category_id', $category_id)->skip(3)->take(6)->get();

    	return view('page.home_view')
    			->with('product_list', $product_list)
                ->with('related_products_active',$related_products_active)
                ->with('related_products',$related_products);
    }

    public function search(Request $request){

        $keywords = $request->keywords;
        $search_cate = Category::where('category_status', '1')->where('category_name', 'like', '%'.$keywords.'%')->get();
        $search_brand = Brand::where('brand_status', '1')->where('brand_name', 'like', '%'.$keywords.'%')->get();
        $search_product = Product::where('product_name', 'like', '%'.$keywords.'%')->get();

        session::put('keywords', $keywords);
        return view('page.search_view')->with('search_cate', $search_cate)
                                     ->with('search_brand', $search_brand)
                                     ->with('search_product', $search_product);
    }
}
