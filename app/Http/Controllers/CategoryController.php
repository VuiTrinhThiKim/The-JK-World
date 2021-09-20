<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Session;
use Redirect;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    public function loginAuthentication() {
        $ad_username = Session::get('ad_username');

        if($ad_username){
            return Redirect::to('admin_login_view');
        }
        else {
            return Redirect::to('admin')->send('Vui lòng đăng nhập');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->loginAuthentication();

        return view('admin.category.add_category_view');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category;

        $category->category_name = $request->get('categoryName');
        $category->category_description = $request->get('categoryDescription');
        $category->category_status = $request->get('categoryStatus');

        if(Category::where('category_name','LIKE BINARY', $request->categoryName)->first() == null){
                
            $category->save();

            Session::put('messCate','Thêm danh mục mới thành công!!!');
            return view('admin.category.add_category_view');
        }
        Session::put('messCate','Lỗi: Danh mục '.$request->categoryName.' đã có trong cơ sở dữ liệu!!!');
        
        return Redirect::to('/admin/category/add');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, $category_id)
    {
        $this->loginAuthentication();

        $edit_cate = Category::where('category_id',$category_id)->get();
        $manager_cate  = view('admin.category.edit_category_view')
                      -> with('edit_category',$edit_cate);

        return view('admin_layout_view')->with('admin.category.edit_category_view', $manager_cate);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category, $category_id)
    {
        $cate = Category::where('category_id',$category_id)->first();

        $cate->category_name = $request->get('categoryName');
        $cate->category_description = $request->get('categoryDescription');
        if(Category::where('category_name',$cate->category_name)->where('category_id', '<>', $category_id)->first() != null) {
            Session::put('messCate','Lỗi: Trùng tên với danh mục khác!!!');
            return Redirect::to('/admin/category/edit/'.$category_id);
        } 
        $cate->save();
        Session::put('messCate','Cập nhật danh mục thành công!!!');
        return Redirect::to('/admin/category/view-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $products, Category $category, $category_id)
    {
        $this->loginAuthentication();

        $products = Product::where('category_id', $category_id)->get();

        foreach ($products as $key => $product) {
            $product->category_id = '0';

            $product->save();
        }

        $category = Category::where('category_id', $category_id)->delete();

        Session::put('messCate','Xóa danh mục thành công!!!');
        return Redirect::to('/admin/category/view-all');
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

        $status_cate = Category::find($category_id)->value('category_status');
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
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show_category(Category $category_list, $category_id)
    {
        $category_list = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $category_name = Category::where('category_id', $category_id)->value('category_name');
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();

        $category_by_id = Product::join('categories', 'products.category_id', '=', 'categories.category_id')->where('products.category_id', $category_id)->get();

        return view('page.category.category_view')->with('category_list', $category_list)
                                     ->with('category_name', $category_name)
                                     ->with('brand_list', $brand_list)
                                     ->with('category_by_id', $category_by_id);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $result = Category::where('category_name', 'LIKE BINARY', '%'.$keywords.'%')->get();

        session::put('keywords', $keywords);
        return view('admin.category.search_category')->with('result', $result);
    }

    public function filter(Request $request)
    {
        $filter_value = $request->filter;
        //dd($filter_value);
        switch ($filter_value) {
            case '0':
                return Redirect::to('/admin/category/view-all');
            case '1':
                $result = Category::orderByDesc('category_name')->get();
                return view('admin.category.search_category')->with('result', $result);
            case '2':
                $result = Category::orderBy('category_name')->get();
                return view('admin.category.search_category')->with('result', $result);
            case '3':
                dd($filter_value);
                break;
            default:
                return Redirect::to('/admin/category/view-all');
                break;
        }
    }
}
