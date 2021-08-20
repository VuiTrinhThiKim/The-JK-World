<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class CategoryController extends Controller
{
    //Admin role
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

    	return view('admin.category.add_category_view');
    }

    public function view_all(){

    	$this->loginAuthentication();

        $all_cate = Category::get();
        $manager_cate = view('admin.category.all_categories_view') 
                     -> with('all_categories', $all_cate);

    	return view('admin_layout_view')->with('admin.category.all_categories_view', $manager_cate);
    }

    public function update_category_status($category_id){

        $this->loginAuthentication();

        $status_cate = Category::where('category_id', $category_id)
                                              ->value('category_status');
        if($status_cate == 0) {
            Category::where('category_id', $category_id)
                                   ->update(['category_status' => 1]);

            Session::put('messCate','Hiển thị danh mục thành công!!!');
        }
        else {
            Category::where('category_id', $category_id)
                                   ->update(['category_status' => 0]);
            Session::put('messCate','Ẩn danh mục thành công!!!');
        }


        return Redirect::to('/admin/category/view-all');
    }

    public function edit($category_id){

        $this->loginAuthentication();

        $edit_cate = Category::where('category_id',$category_id)
                                            ->get();
        $manager_cate  = view('admin.category.edit_category_view')
                      -> with('edit_category',$edit_cate);

        return view('admin_layout_view')->with('admin.category.edit_category_view', $manager_cate);
    }

    public function update(Request $request_update, $category_id){

        $this->loginAuthentication();

        $data_cate = array();

        $data_cate['category_name'] = $request_update->categoryName;
        $data_cate['category_description'] = $request_update->categoryDescription;

        Category::where('category_id',$category_id)
                               ->update($data_cate);

        Session::put('messCate','Cập nhật danh mục thành công!!!');
        return Redirect::to('/admin/category/view-all');
    }

    public function save(Request $request_cate){

        $this->loginAuthentication();

        $data_cate = array();

        $data_cate['category_name'] = $request_cate->categoryName;
        $data_cate['category_description'] = $request_cate->categoryDescription;
        $data_cate['category_status'] = $request_cate->categoryStatus;

        if(Category::where('category_name',$request_cate->categoryName)
                                  ->first() == null){
            
            Category::insert($data_cate);
            Session::put('messCate','Thêm danh mục mới thành công!!!');
        }
        else {
            Session::put('messCate','Lỗi: Danh mục '.$request_cate->categoryName.' đã có trên hệ thống!!!');
        }
        return view('admin.category.add_category_view');
    }

    public function delete($category_id){

        $this->loginAuthentication();

        Category::where('category_id', $category_id)
                               ->delete();

        Session::put('messCate','Xóa danh mục thành công!!!');
        return Redirect::to('/admin/category/view-all');
    }

    //Web role
    public function show_category($category_id){
        $category_list = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $category_name = Category::where('category_id', $category_id)->value('category_name');
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();
        $category_by_id = Product::join('categories', 'products.category_id', '=', 'categories.category_id')->where('products.category_id', $category_id)->get();

        return view('page.category.category_view')->with('category_list', $category_list)
                                     ->with('category_name', $category_name)
                                     ->with('brand_list', $brand_list)
                                     ->with('category_by_id', $category_by_id);
    }
}
