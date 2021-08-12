<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Session;
use DB;


class CategoriesController extends Controller
{
    public function add_category(){

    	return view('admin.add_category_view');
    }

    public function all_categories(){
    	
        $all_cate = DB::table('categories')->get();
        $manager_cate = view('admin.all_categories_view') 
                     -> with('all_categories', $all_cate);

    	return view('admin_layout_view')->with('admin.all_categories_view', $manager_cate);
    }

    public function update_category_status($category_id){

        $status_cate = DB::table('categories')->where('category_id', $category_id)
                                              ->get('status');
        if($status_cate == '[{"status":0}]') {
            DB::table('categories')->where('category_id', $category_id)
                                   ->update(['status' => 1]);

            Session::put('messCate','Hiển thị danh mục thành công!!!');
        }
        else {
            DB::table('categories')->where('category_id', $category_id)
                                   ->update(['status' => 0]);
            Session::put('messCate','Ẩn danh mục thành công!!!');
        }


        return Redirect::to('all-categories');
    }

    public function edit_category($category_id){

        $edit_cate = DB::table('categories')->where('category_id',$category_id)
                                            ->get();
        $manager_cate  = view('admin.edit_category_view')
                      -> with('edit_category',$edit_cate);

        return view('admin_layout_view')->with('admin.edit_category_view', $manager_cate);
    }

    public function update_category(Request $request_update, $category_id){

        $data_cate = array();

        $data_cate['category_name'] = $request_update->categoryName;
        $data_cate['description'] = $request_update->categoryDescription;

        DB::table('categories')->where('category_id',$category_id)
                               ->update($data_cate);

        Session::put('messCate','Cập nhật danh mục thành công!!!');
        return Redirect::to('all-categories');
    }

    public function save_category(Request $request_cate){

        $data_cate = array();

        $data_cate['category_name'] = $request_cate->categoryName;
        $data_cate['description'] = $request_cate->categoryDescription;
        $data_cate['status'] = $request_cate->categoryStatus;

        DB::table('categories')->insert($data_cate);

        Session::put('messCate','Thêm danh mục mới thành công!!!');
        return view('admin.add_category_view');
    }

    public function delete_category($category_id){

        DB::table('categories')->where('category_id', $category_id)
                               ->delete();

        Session::put('messCate','Xóa danh mục thành công!!!');
        return Redirect::to('all-categories');
    }
}
