<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use DB;

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

        $category_list = DB::table('categories')->orderby('category_name', 'asc')->get();
        $brand_list = DB::table('brands')->orderby('brand_name', 'asc')->get();

        return view('admin.product.add_product_view')->with('category_list', $category_list)
        											 ->with('brand_list', $brand_list);
    }

    public function view_all(){

    	$this->loginAuthentication();

        $all_product = DB::table('products')->get();
        $manager_product = view('admin.product.all_products_view') 
                     -> with('all_products', $all_product);

    	return view('admin_layout_view')->with('admin.product.all_products_view', $manager_product);
    }

    public function update_product_status($product_id){

        $this->loginAuthentication();

        $status_product = DB::table('products')->where('product_id', $product_id)
                                              ->get('status');
        if($status_product == '[{"status":0}]') {
            DB::table('products')->where('product_id', $product_id)
                                   ->update(['status' => 1]);

            Session::put('messProduct','Hiển thị danh mục thành công!!!');
        }
        else {
            DB::table('products')->where('product_id', $product_id)
                                   ->update(['status' => 0]);
            Session::put('messProduct','Ẩn danh mục thành công!!!');
        }


        return Redirect::to('/admin/product/all-products');
    }

    public function edit($product_id){

        $this->loginAuthentication();

        $edit_product = DB::table('products')->where('product_id',$product_id)
                                            ->get();
        $manager_product  = view('admin.product.edit_product_view')
                      -> with('edit_product',$edit_product);

        return view('admin_layout_view')->with('admin.product.edit_product_view', $manager_product);
    }

    public function update(Request $request_update, $product_id){

        $this->loginAuthentication();

        $data_product = array();

        $data_product['product_name'] = $request_update->productName;
        $data_product['description'] = $request_update->productDescription;

        DB::table('products')->where('product_id',$product_id)
                               ->update($data_product);

        Session::put('messProduct','Cập nhật danh mục thành công!!!');
        return Redirect::to('/admin/product/all-products');
    }

    public function save(Request $request_product){

        $this->loginAuthentication();

        $data_product = array();

        $data_product['product_name'] = $request_product->productName;
        $data_product['description'] = $request_product->productDescription;
        $data_product['content'] = $request_product->productContent;
        $data_product['price'] = $request_product->productPrice;
        $data_product['image'] = $request_product->productImage;
        $data_product['category_id'] = $request_product->categoryID;
        $data_product['brand_id'] = $request_product->brandID;
        $data_product['status'] = $request_product->productStatus;

        if(DB::table('products')->where('product_name',$request_product->productName)
                                  ->first() == null){
            
            DB::table('products')->insert($data_product);
            Session::put('messProduct','Thêm danh mục mới thành công!!!');
        }
        else {
            Session::put('messProduct','Lỗi: Danh mục '.$request_product->productName.' đã có trên hệ thống!!!');
        }
        return view('admin.product.add_product_view');
    }

    public function delete($product_id){

        $this->loginAuthentication();

        DB::table('products')->where('product_id', $product_id)
                               ->delete();

        Session::put('messProduct','Xóa danh mục thành công!!!');
        return Redirect::to('/admin/product/view-all');
    }
}
