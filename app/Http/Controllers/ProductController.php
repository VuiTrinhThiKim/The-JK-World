<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\Product;
use App\Models\ProductImages;
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
        $edit_product_img = ProductImages::where('product_id',$product_id)
                                            ->get('image_name');
        $manager_product  = view('admin.product.edit_product_view')
                      ->with('edit_product', $edit_product)
                      ->with('edit_product_img', $edit_product_img)
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

        //Check file upload
        if($request_update->hasFile('productImage')) {

			$allowedfileExtension = ['jpg', 'jpeg', 'png'];
			$files = $request_update->file('productImage');
            // $flag = true -> save to DB
			$flag = true;
			// Check all files upload have extension is in $allowedfileExtension
			foreach($files as $file) {
				$extension = $file->getClientOriginalExtension();
				$check = in_array($extension,$allowedfileExtension);

				if(!$check) {
                    $flag = false;// -> donot save to DB
					break;
				}
			}
			if($flag) {
	                // Update product
					ProductImages::where('product_id', $product_id)
                               ->delete();
					Product::where('product_id',$product_id)
                               ->update($data_product);
                    // Update img with product_id
					foreach ($request_update->productImage as $photo) {
						$filename = $photo->storeAs('photos', $photo->getClientOriginalName());
						ProductImages::insert([
							'product_id' => $product_id,
							'image_name' => $filename
						]);
					}
					Session::put('messProduct','Cập nhật sản phẩm thành công');
				} else {
					Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
				}
			}

        return Redirect::to('/admin/product/view-all');
    }


    public function save(Request $request){

        $this->loginAuthentication();

        $this->validate($request, [
			'productName' => 'required',
			'productContent'=>'required',]
		);

        $data_product = array();

        $data_product['product_name'] = $request->productName;
        $data_product['product_description'] = $request->productDescription;
        $data_product['content'] = $request->productContent;
        $data_product['price'] = $request->productPrice;
        $data_product['category_id'] = $request->categoryID;
        $data_product['brand_id'] = $request->brandID;
        $data_product['product_status'] = $request->productStatus;

       	//Check file upload
        if($request->hasFile('productImage')) {

			$allowedfileExtension = ['jpg', 'jpeg', 'png'];
			$files = $request->file('productImage');
            // $flag = true -> save to DB
			$flag = true;
			// Check all files upload have extension is in $allowedfileExtension
			foreach($files as $file) {
				$extension = $file->getClientOriginalExtension();
				$check = in_array($extension,$allowedfileExtension);

				if(!$check) {
                    $flag = false;// -> donot save to DB
					break;
				}
			}
			if(Product::where('product_name',$request->productName)->first() == null){
            
	            if($flag) {
	                // Save product
					Product::insert($data_product);
					// Get product_id
					$productID = Product::where('product_name', $request->productName)->value('product_id');
	                // Save img with product_id
					foreach ($request->productImage as $photo) {
						$filename = $photo->storeAs('photos', $photo->getClientOriginalName());
						ProductImages::insert([
							'product_id' => $productID,
							'image_name' => $filename
						]);
					}
					Session::put('messProduct','Thêm sản phẩm thành công');
				} else {
					Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
				}
	        }
	        else {
	            Session::put('messProduct','Lỗi: Sản phẩm '.$request->productName.' đã có trên hệ thống!!!');
	        }
		}
        
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
}
