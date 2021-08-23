<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use Session;
use Redirect;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function loginAuthentication() {
        $ad_username = Session::get('username');

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
    public function create() {

        $this->loginAuthentication();

        return view('admin.brand.add_brand_view');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request) {

        $brand = new Brand;

        $brand->brand_name = $request->get('brandName');
        $brand->brand_description = $request->get('brandDescription');
        $brand->brand_status = $request->get('brandStatus');

        if(Brand::where('brand_name',$request->brandName)->first() == null){
                
            $brand->save();

            Session::put('messBrand','Thêm brand mới thành công!!!');
            return view('admin.brand.add_brand_view');
        }
        Session::put('messBrand','Lỗi: Brand '.$request->brandName.' đã có trong cơ sở dữ liệu!!!');
        
        return Redirect::to('/admin/brand/add');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand, $brand_id) {

        $this->loginAuthentication();

        $edit_brand = Brand::where('brand_id',$brand_id)->get();
        $manager_brand  = view('admin.brand.edit_brand_view')
                      -> with('edit_brand',$edit_brand);

        return view('admin_layout_view')->with('admin.brand.edit_brand_view', $manager_brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand, $brand_id) {

        $brand = Brand::where('brand_id',$brand_id)->first();

        $brand->brand_name = $request->get('brandName');
        $brand->brand_description = $request->get('brandDescription');

        $brand->save();
        Session::put('messBrand','Cập nhật brand thành công!!!');
        return Redirect::to('/admin/brand/view-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $products, Brand $brand, $brand_id){

        $this->loginAuthentication();

        $products = Product::where('brand_id', $brand_id)->get();

        foreach ($products as $key => $product) {
        	$product->brand_id = '0';

        	$product->save();
        }

        $brand = Brand::where('brand_id', $brand_id)->delete();

        Session::put('messBrand','Xóa brand thành công!!!');
        return Redirect::to('/admin/brand/view-all');
    }

    public function view_all(){

        $this->loginAuthentication();

        $all_brand = Brand::get();
        $manager_brand = view('admin.brand.all_brands_view') 
                     -> with('all_brands', $all_brand);

        return view('admin_layout_view')->with('admin.brand.all_brands_view', $manager_brand);
    }

    public function update_brand_status($brand_id){

        $this->loginAuthentication();

        $status = Brand::find($brand_id)->value('brand_status');
        if($status == 0) {
            Brand::where('brand_id', $brand_id)
                                   ->update(['brand_status' => 1]);

            Session::put('messBrand','Hiển thị brand thành công!!!');
        }
        else {
            Brand::where('brand_id', $brand_id)
                                   ->update(['brand_status' => 0]);
            Session::put('messBrand','Ẩn brand thành công!!!');
        }

        return Redirect::to('/admin/brand/view-all');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show_brand($brand_id)
    {
        $category_list = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $brand_list = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();
        $brand_name = Brand::where('brand_id', $brand_id)->value('brand_name');

        $brand_by_id = Product::join('brands', 'products.brand_id', '=', 'brands.brand_id')
                            ->where('products.brand_id', $brand_id)->get();

        return view('page.brand.brand_view')->with('category_list', $category_list)
                                     ->with('brand_list', $brand_list)
                                     ->with('brand_name', $brand_name)
                                     ->with('brand_by_id', $brand_by_id);
    }
    
}
