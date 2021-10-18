<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        $slug = Str::of($brand->brand_name)->slug('-');
        if(Brand::where('brand_slug', $slug)->first() == null)
        {
            $brand->brand_slug = $slug;
        }
        else {
            $brand->brand_slug = $slug.'-'.rand(0,255);
        }

        if(Brand::where('brand_name', 'LIKE BINARY', $request->brandName)->first() == false)
        {
                
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

        $slug = Str::of($brand->brand_name)->slug('-');

        if(Brand::where('brand_name', 'LIKE BINARY', $brand->brand_name)
                ->where('brand_id', '<>', $brand_id)->first() != null)
        {
            Session::put('messBrand','Lỗi: Trùng tên với sản phẩm khác!!!');
            return Redirect::to('/admin/brand/edit/'.$brand_id);
        } 

        if(Brand::where('brand_slug', $slug)->where('brand_id', $brand_id)->first() != null) {
            $brand->brand_slug = $slug;
        }
        else {
            $brand->brand_slug = $slug.'-'.rand(0,255);
        }
        
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
        	$product->brand_id = '1';

        	$product->save();
        }

        $brand = Brand::where('brand_id', $brand_id)->delete();

        Session::put('messBrand','Xóa brand thành công!!!');
        return Redirect::to('/admin/brand/view-all');
    }

    public function view_all(){

        $this->loginAuthentication();

        $brands = Brand::paginate(5);
        //dd($brands->links());
        $count_brand = Brand::count();
        $manager_brand = view('admin.brand.all_brands_view') 
                     -> with('brands', $brands);

        return view('admin_layout_view')->with('admin.brand.all_brands_view', $manager_brand);
    }

    public function update_brand_status($brand_id){

        $this->loginAuthentication();
        //Get brand from id
        $brand = Brand::where('brand_id', $brand_id);

        //Get brand status
        $status = $brand->value('brand_status');
        if($status == 0) {
            $brand->update(['brand_status' => 1]);

            Session::put('messBrand','Hiển thị brand thành công!!!');
        }
        else {
            $brand->update(['brand_status' => 0]);

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
    public function show_brand($brand_slug)
    {
        $brand_id = Brand::where('brand_slug', $brand_slug)->value('brand_id');

        $brand_name = Brand::where('brand_id', $brand_id)->value('brand_name');

        $products_brand =  Brand::find($brand_id)->products->where('product_status', 1);
        //dd($products_brand);
        return view('page.brand.brand_view')
                                     ->with('brand_name', $brand_name)
                                     ->with('products_brand', $products_brand);
    }
    
    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $result = Brand::where('brand_name', 'LIKE BINARY', '%'.$keywords.'%')->paginate(5);

        Session::put('keywords', $keywords);
        Session::forget('filter');
        Session::forget('filter_id');
        return view('admin.brand.search_brand')->with('result', $result);
    }

    public function filter(Request $request)
    {
        $filter_value = $request->filter;
        Session::forget('keywords');
        //dd($filter_value);
        switch ($filter_value) {
            case '0':
                return Redirect::to('/admin/brand/view-all');
            case '1':
                Session::put('filter', 'A-Z');
                Session::put('filter_id', 1);
                $result = Brand::orderBy('brand_name')->paginate(5);
                //dd($result);
                return view('admin.brand.search_brand')->with('result', $result);
            case '2':
                Session::put('filter', 'Z-A');
                Session::put('filter_id', 2);
                $result = Brand::orderByDesc('brand_name')->paginate(5);
                return view('admin.brand.search_brand')->with('result', $result);
            case '3':
                Session::put('filter', 'Đang hiển thị trên web');
                Session::put('filter_id', 3);
                $result = Brand::where('brand_status', 1)->paginate(5);
                return view('admin.brand.search_brand')->with('result', $result);
            case '4':
                Session::put('filter', 'Đang bị ẩn khỏi web');
                Session::put('filter_id', 4);
                $result = Brand::where('brand_status', 0)->paginate(5);
                return view('admin.brand.search_brand')->with('result', $result);
            default:
                return Redirect::to('/admin/brand/view-all');
        }
    }
}
