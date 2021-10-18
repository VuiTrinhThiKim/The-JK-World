<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Str;
use Session;
use Redirect;

class ProductController extends Controller
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
    public function create()
    {
        $this->loginAuthentication();

        

        return view('admin.product.add_product_view');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;

        $product->product_name = $request->get('productName');
        $product->product_description = $request->get('productDescription');
        $product->content = $request->get('productContent');
        $product->product_qty = $request->get('productQty');
        $product->price = $request->get('productPrice');
        $product->weight = $request->get('productWeight');
        $product->category_id = $request->get('categoryID');
        $product->brand_id = $request->get('brandID');
        $product->product_status = $request->get('productStatus');

        $slug = Str::of($product->product_name)->slug('-');
        if(Product::where('product_slug', $slug)->first() == null)
        {
            $product->product_slug = $slug;
        }
        else {
            $product->product_slug = $slug.'-'.rand(0,255);
        }

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

                    $product->product_image = $new_image;
                    // Save product
                    $product->save();
                    // Get product_id
                    Session::put('messProduct','Thêm sản phẩm thành công');
                    return Redirect::to('/admin/product/view-all');
                } else {
                    Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
                    return Redirect::to('/admin/product/add');
                }
            }
            else {
                Session::put('messProduct','Lỗi: Sản phẩm '.$request->productName.' đã có trên hệ thống!!!');
                return Redirect::to('/admin/product/view-all');
            }
        }
        $product->product_image = 'no-pic.png';
        // Save product
        $product->save();
        // Get product_id
        Session::put('messProduct','Thêm sản phẩm thành công');
        return Redirect::to('/admin/product/view-all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $product_id)
    {
        $this->loginAuthentication();


        $edit_product = Product::where('product_id',$product_id)
                                            ->get();
        $manager_product  = view('admin.product.edit_product_view')
                      ->with('edit_product', $edit_product);
        //dd($manager_product);
        return view('admin_layout_view')->with('admin.product.edit_product_view', $manager_product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, $product_id)
    {
        $product = Product::where('product_id',$product_id)->first();

        $product->product_name = $request->get('productName');
        $product->product_description = $request->get('productDescription');
        $product->content = $request->get('productContent');
        $product->product_qty = $request->get('productQty');
        $product->price = $request->get('productPrice');
        $product->weight = $request->get('productWeight');
        $product->category_id = $request->get('categoryID');
        $product->brand_id = $request->get('brandID');


        if(Product::where('product_name', 'LIKE BINARY', $product->product_name)->where('product_id', '<>', $product_id)->first() != null) {
            Session::put('messProduct','Lỗi: Trùng tên sản phẩm!!!');
            return Redirect::to('/admin/product/edit/'.$product_id);
        }

        $slug = Str::of($product->product_name)->slug('-');

        if(Product::where('product_slug', $slug)->where('product_id', $product_id)->first() != null) {
            $product->product_slug = $slug;
        }
        else {
            $product->product_slug = $slug.'-'.rand(0,255);
        }
        
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
            if($flag) {
                $get_image_name = $image->getClientOriginalName();
                $new_image_name = current(explode('.',$get_image_name));
                $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                $image->move('upload/products', $new_image);

                $product->product_image = $new_image;
                // Save product
                $product->save();
                // Get product_id
                Session::put('messProduct','Cập nhật sản phẩm thành công');
                return Redirect::to('/admin/product/view-all');
            } else {
                Session::put('messProduct','Định dạng ảnh phải là jpg, jpeg hoặc png.');
                return Redirect::to('/admin/product/edit/'.$product_id);
            }
        }
        $product_img = Product::where('product_id', $product_id)->value('product_image');
        $product->product_image = $product_img;
        // Save product
        $product->save();
        // Get product_id
        Session::put('messProduct','Cập nhật sản phẩm thành công');
        return Redirect::to('/admin/product/view-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $product_id)
    {
        $this->loginAuthentication();

        $product = Product::where('product_id', $product_id)
                               ->delete();
        Session::put('messProduct','Xóa sản phẩm thành công!!!');
        return Redirect::to('/admin/product/view-all');
    }

    public function view_all(){

        $this->loginAuthentication();

        $products = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
                            ->join('brands', 'brands.brand_id', '=', 'products.brand_id')
                            ->orderbyDesc('products.product_id')
                            ->paginate(5);
        //dd($all_product);
        $manager_product = view('admin.product.all_products_view') 
                     -> with('products', $products);

        return view('admin_layout_view')->with('admin.product.all_products_view', $manager_product);
    }

    public function update_product_status($product_id){

        $this->loginAuthentication();

        $status_product = Product::where('product_id', $product_id)->value('product_status');

        if($status_product == 0) {
            $re = Product::where('product_id', $product_id)->update(['product_status' => 1]);

            Session::put('messProduct','Hiển thị sản phẩm thành công!!!');
            //dd($status_product);  
        }
        else {
            Product::where('product_id', $product_id)->update(['product_status' => 0]);
            Session::put('messProduct','Ẩn sản phẩm thành công!!!');
            //dd($status_product);  
        }

        return Redirect::to('/admin/product/view-all');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show_product_detail($product_slug)
    {
        $product_id = Product::where('product_slug', $product_slug)->value('product_id');

        $product_details = Product::join('categories', 'categories.category_id', '=', 'products.category_id')
                                    ->join('brands', 'brands.brand_id', '=', 'products.brand_id')
                                    ->where('products.product_id', $product_id)->get();

        //Get category id
        foreach ($product_details as $key => $value) {
            $category_id = $value->category_id;
        }

        $related_products = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id')
            ->where('categories.category_id', $category_id)
            ->whereNotIn('products.product_id', [$product_id]);

        $related_products_active = $related_products->limit(3)->get();

        $related_products_no_active = $related_products->skip(3)->take(6)->get();

        return view('page.product.product_view')
                    ->with('product_details', $product_details)
                    ->with('related_products', $related_products_no_active)
                    ->with('related_products_active', $related_products_active);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $result = Product::where('product_name', 'LIKE BINARY', '%'.$keywords.'%')->get();

        Session::put('keywords', $keywords);
        Session::forget('filter');
        Session::forget('filter_id');
        return view('admin.product.search_product')->with('result', $result);
    }

    public function filter(Request $request)
    {
        $filter_value = $request->filter;
        Session::forget('keywords');
        //dd($filter_value);
        $all_products = Product::join('categories', 'categories.category_id', '=', 'products.category_id')->join('brands', 'brands.brand_id', '=', 'products.brand_id');
        switch ($filter_value) {
            case '0':
                return Redirect::to('/admin/product/view-all');
            case '1':
                Session::put('filter', 'A-Z');
                Session::put('filter_id', 1);
                $result = $all_products->orderBy('product_name')->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            case '2':
                Session::put('filter', 'Z-A');
                Session::put('filter_id', 2);
                $result = $all_products->orderByDesc('product_name')->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            case '3':
                Session::put('filter', 'Giá tăng dần');
                Session::put('filter_id', 3);
                $result = $all_products->orderBy('price')->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            case '4':
                Session::put('filter', 'Giá giảm dần');
                Session::put('filter_id', 4);
                $result = $all_products->orderByDesc('price')->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            case '5':
                Session::put('filter', 'Đang hiển thị trên web');
                Session::put('filter_id', 5);
                $result = $all_products->where('product_status', 1)->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            case '6':
                Session::put('filter', 'Đang bị ẩn khỏi web');
                Session::put('filter_id', 6);
                $result = $all_products->where('product_status', 0)->paginate(5);
                return view('admin.product.search_product')->with('result', $result);
            default:
                return Redirect::to('/admin/product/view-all');
        }
    }
}
