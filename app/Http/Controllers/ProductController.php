<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function loginAuthentication() {
        $ad_username = Session::get('username');

        if($ad_username){
            return Redirect::to('admin_login_view');
        }
        else {
            return Redirect::to('admin')->send('Vui lòng đăng nhập');
        }
    }



    public function add(){

        $this->loginAuthentication();

        $category_list = Category::orderby('category_name', 'asc')->get();
        $brand_list = Brand::orderby('brand_name', 'asc')->get();

        return view('admin.product.add_product_view')->with('category_list', $category_list)
        											 ->with('brand_list', $brand_list);
    }

    public function view_all(){

    	$this->loginAuthentication();

        $all_product = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')->orderby('products.product_id', 'asc')->get();
        //dd($all_product);
        $manager_product = view('admin.product.all_products_view') 
                     -> with('all_products', $all_product);

    	return view('admin_layout_view')->with('admin.product.all_products_view', $manager_product);
    }

    public function update_product_status($product_id){

        $this->loginAuthentication();

        $status_product = Product::where('product_id', $product_id)
                                              ->value('product_status');
        if($status_product == 0) {
            Product::where('product_id', $product_id)
                                   ->update(['product_status' => 1]);

            Session::put('messProduct','Hiển thị sản phẩm thành công!!!');
        }
        else {
            Product::where('product_id', $product_id)
                                   ->update(['product_status' => 0]);
            Session::put('messProduct','Ẩn sản phẩm thành công!!!');
        }

        return Redirect::to('/admin/product/view-all');
    }


    public function edit($product_id){

        $this->loginAuthentication();

        $category_list = Category::orderby('category_name', 'asc')->get();
        $brand_list = Brand::orderby('brand_name', 'asc')->get();

        $edit_product = Product::where('product_id',$product_id)
                                            ->get();
        $manager_product  = view('admin.product.edit_product_view')
                      ->with('edit_product', $edit_product)
                      ->with('category_list', $category_list)
                      ->with('brand_list',$brand_list);
        //dd($manager_product);
        return view('admin_layout_view')->with('admin.product.edit_product_view', $manager_product);
    }

    public function update(Request $request_update, $product_id){

        $this->loginAuthentication();

        $data_product = array();

        $data_product['product_name'] = $request_update->productName;
        $data_product['product_description'] = $request_update->productDescription;
        $data_product['content'] = $request_update->productContent;
        $data_product['price'] = $request_update->productPrice;
        $data_product['category_id'] = $request_update->categoryID;
        $data_product['brand_id'] = $request_update->brandID;

        $image = $request_update->file('productImage');
        //Check file upload
        if($image) {

            $allowedfileExtension = ['jpg', 'jpeg', 'png'];
            
            //$flag = true -> save to DB
            $flag = true;
            // Check all files upload have extension is in $allowedfileExtension
            $extension = $image->getClientOriginalExtension();
            //$check = in_array($extension,$allowedfileExtension);

            if(!$check) {
                $flag = false;// -> donot save to DB
           }
            if($flag) {
                    $get_image_name = $image->getClientOriginalName();
                    $new_image_name = current(explode('.',$get_image_name));
                    $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                    $image->move('public/upload/products', $new_image);
                    $data_product['product_image'] = $new_image;
                    // Save product
                    Product::where('product_id', $product_id)->update($data_product);
                    // Get product_id
                    Session::put('messProduct','Cập nhật sản phẩm thành công');
                    return Redirect::to('/admin/product/view-all');
                } else {
                    Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
                    return Redirect::to('/admin/product/view-all');
                }
        }
        else {
            $product_img = Product::where('product_id', $product_id)->value('product_image');
            $data_product['product_image'] = $product_img;
            Product::where('product_id', $product_id)->update($data_product);
            // Get product_id
            Session::put('messProduct','Cập nhật sản phẩm thành công');
        return Redirect::to('/admin/product/view-all');
        }
    }


    public function save(Request $request){

        $this->loginAuthentication();        

        $data_product = array();

        $data_product['product_name'] = $request->productName;
        $data_product['product_description'] = $request->productDescription;
        $data_product['content'] = $request->productContent;
        $data_product['price'] = $request->productPrice;
        $data_product['category_id'] = $request->categoryID;
        $data_product['brand_id'] = $request->brandID;
        $data_product['product_status'] = $request->productStatus;
        $image = $request->file('productImage');
       	//Check file upload
        if($image) {

			$allowedfileExtension = ['jpg', 'jpeg', 'png'];
			
            // $flag = true -> save to DB
			$flag = true;
			// Check all files upload have extension is in $allowedfileExtension
			$extension = $image->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);

            if(!$check) {
                $flag = false;// -> donot save to DB
            }
			if(Product::where('product_name',$request->productName)->first() == null){
            
	            if($flag) {
                    $get_image_name = $image->getClientOriginalName();
                    $new_image_name = current(explode('.',$get_image_name));
                    $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                    $image->move('public/upload/products', $new_image);
                    $data_product['product_image'] = $new_image;
	                // Save product
					Product::insert($data_product);
					// Get product_id
					Session::put('messProduct','Thêm sản phẩm thành công');
                    return Redirect::to('/admin/product/add');
				} else {
					Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
                    return Redirect::to('/admin/product/add');
				}
	        }
	        else {
	            Session::put('messProduct','Lỗi: Sản phẩm '.$request->productName.' đã có trên hệ thống!!!');
                return Redirect::to('/admin/product/add');
	        }
		}
        $data_product['product_image'] = 'no-pic.jpg';
        // Save product
        Product::insert($data_product);
        // Get product_id
        Session::put('messProduct','Thêm sản phẩm thành công');
        return Redirect::to('/admin/product/add');
    }

    public function delete($product_id){

        $this->loginAuthentication();

        ProductImages::where('product_id', $product_id)
                               ->delete();
        Product::where('product_id', $product_id)
                               ->delete();
        Session::put('messProduct','Xóa danh mục thành công!!!');
        return Redirect::to('/admin/product/view-all');
    }

    
    //Web role
    public function show_product_detail($product_id){
        $category_list = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();
        $product_details = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->where('products.product_id', $product_id)->get();

        //Get category id
        foreach ($product_details as $key => $value) {
            $category_id = $value->category_id;
        }

        $related_products = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->where('categories.category_id', $category_id)
            ->whereNotIn('products.product_id', [$product_id])->get();

        return view('page.product.product_view')->with('category_list', $category_list)
                                     ->with('brand_list', $brand_list)
                                     ->with('product_details', $product_details)
                                     ->with('related_products', $related_products);

    }
}