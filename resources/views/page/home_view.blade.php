@extends('layout_view')

@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới</h2>
    @foreach($product_list as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <form>
                        {{csrf_field()}}
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
                            <img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                            <h2>{{number_format($product->price).' ₫'}}</h2>
                            <p>{{$product->product_name}}</p>
                        </a>

                        <button type="button" class="btn btn-default add-to-cart" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào danh sách yêu thích</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach   
</div><!--features_items-->

<!--category-tab
<div class="category-tab">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach($category_list as $key => $category)
            <li class="active"><a href="#{{$category->category_slug}}" data-toggle="tab">{{$category->category_name}}</a></li>
            @endforeach
    </div>
    @foreach($category_list as $key => $category)
    <div class="tab-content">
        <div class="tab-pane fade active in" id="{{$category->category_slug}}" >
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="" />
                            <h2>260000 VNĐ</h2>
                            <p>Chân váy Đông Lâm Xã</p>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
category-tab-->

<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm gợi ý</h2>
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                @foreach($related_products_active as $key => $product)  
                <div class="col-sm-4">
                    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img width="250" height="250" src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                                    <h2>{{number_format($product->price).' ₫'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>    
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="item">
                @foreach($related_products as $key => $product)  
                <div class="col-sm-4">
                    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img width="250" height="250" src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                                    <h2>{{number_format($product->price).' ₫'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>    
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>          
    </div>
</div><!--/recommended_items-->

@endsection