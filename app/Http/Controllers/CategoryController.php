<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Str;
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

        $slug = Str::of($category->category_name)->slug('-');
        if(Category::where('category_slug', $slug)->first() == null)
        {
            $category->category_slug = $slug;
        }
        else {
            $category->category_slug = $slug.'-'.rand(0,255);
        }
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
        $category = Category::where('category_id',$category_id)->first();

        $category->category_name = $request->get('categoryName');
        $category->category_description = $request->get('categoryDescription');

        if(Category::where('category_name', 'LIKE BINARY' ,$category->category_name)->where('category_id', '<>', $category_id)->first() != null) {
            Session::put('messCate','Lỗi: Trùng tên với danh mục khác!!!');
            return Redirect::to('/admin/category/edit/'.$category_id);
        } 
        $slug = Str::of($category->category_name)->slug('-');

        if(Category::where('category_slug', $slug)->where('category_id', $category_id)->first() != null) {
            $category->category_slug = $slug;
        }
        else {
            $category->category_slug = $slug.'-'.rand(0,255);
        }
        
        $category->save();
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
            $product->category_id = '1';

            $product->save();
        }

        $category = Category::where('category_id', $category_id)->delete();

        Session::put('messCate','Xóa danh mục thành công!!!');
        return Redirect::to('/admin/category/view-all');
    }

    public function view_all(){

        $this->loginAuthentication();

        $categories = Category::paginate(5);
        $manager_cate = view('admin.category.all_categories_view') 
                     -> with('categories', $categories);

        return view('admin_layout_view')->with('admin.category.all_categories_view', $manager_cate);
    }

    public function update_category_status($category_id){

        $this->loginAuthentication();
        //Get category by id
        $category = Category::where('category_id', $category_id);

        //Get category status
        $status = $category->value('category_status');
        if($status == 0) {
            $category->update(['category_status' => 1]);

            Session::put('messCate','Hiển thị danh mục thành công!!!');
        }
        else {
            $category->update(['category_status' => 0]);

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
    public function show_category(Category $category_list, $category_slug)
    {
        $category_id = Category::where('category_slug', $category_slug)->value('category_id');
        $category_name = Category::where('category_id', $category_id)->value('category_name');

        $products_category =  Category::find($category_id)->products->where('product_status', 1);
        //dd($products_category);
        return view('page.category.category_view')->with('category_name', $category_name)
                                     ->with('products_category', $products_category);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $result = Category::where('category_name', 'LIKE BINARY', '%'.$keywords.'%')->paginate(5);

        Session::put('keywords', $keywords);
        Session::forget('filter');
        Session::forget('filter_id');
        return view('admin.category.search_category')->with('result', $result);
    }

    public function filter(Request $request)
    {
        $filter_value = $request->filter;
        Session::forget('keywords');
        //dd($filter_value);
        switch ($filter_value) {
            case '0':
                return Redirect::to('/admin/category/view-all');
            case '1':
                Session::put('filter', 'A-Z');
                Session::put('filter_id', 1);
                $result = Category::orderBy('category_name')->paginate(5);
                return view('admin.category.search_category')->with('result', $result);
            case '2':
                Session::put('filter', 'Z-A');
                Session::put('filter_id', 2);
                $result = Category::orderByDesc('category_name')->paginate(5);
                return view('admin.category.search_category')->with('result', $result);
            case '3':
                Session::put('filter', 'Đang hiển thị trên web');
                Session::put('filter_id', 3);
                $result = Category::where('category_status', 1)->paginate(5);
                return view('admin.category.search_category')->with('result', $result);
            case '4':
                Session::put('filter', 'Đang bị ẩn khỏi web');
                Session::put('filter_id', 4);
                $result = Category::where('category_status', 0)->paginate(5);
                return view('admin.category.search_category')->with('result', $result);
            default:
                return Redirect::to('/admin/category/view-all');
        }
    }
}
