<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){

    	$category_list = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();
        $product_list = Product::where('product_status', '1')->orderby('product_name', 'asc')->limit(3)->get();

    	return view('page.home_view')->with('category_list', $category_list)
    								 ->with('brand_list', $brand_list)
    								 ->with('product_list', $product_list);
    }
}
