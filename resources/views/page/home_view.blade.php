@extends('layout_view')

@section('slider')
<div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>
                        
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-6">
                                    <h1>The JK World</h1>
                                    <h2>Thế giới JK</h2>
                                    <p>Mang JK đến gần bạn hơn</p>
                                    <button type="button" class="btn btn-default get">Mua ngay</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('frontend/images/nhat-nguyet.jpg')}}" class="girl img-responsive" alt="" />
                                    <!--<img src="{{('frontend/images/pricing.png')}}"  class="pricing" alt="" />-->
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1>The JK World</h1>
                                    <h2>Thế giới JK</h2>
                                    <p>Mang JK đến gần bạn hơn</p>
                                    <button type="button" class="btn btn-default get">Mua ngay</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('frontend/images/nhi-nguyet.jpg')}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="col-sm-6">
                                    <h1>The JK World</h1>
                                    <h2>Thế giới JK</h2>
                                    <p>Mang JK đến gần bạn hơn</p>
                                    <button type="button" class="btn btn-default get">Mua ngay</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="{{asset('frontend/images/tam-nguyet.jpg')}}" class="girl img-responsive" alt="" />
                                </div>
                            </div>
                            
                        </div>
                        
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection

@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới</h2>
    @foreach($product_list as $key => $product)
    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_slug)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{asset('/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                            <h2>{{number_format($product->price).' ₫'}}</h2>
                            <p>{{$product->product_name}}</p>
                            <form action="{{URL::to('/gio-hang')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="productId" value="{{$product->product_id}}">
                                <input name="productQuantity" type="hidden" value="1" />
                                @if($product->product_qty > 0)
                                <button type="submit" class="btn btn-default add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng
                                </button>
                                @else
                                <button type="submit" class="btn btn-default add-to-cart" disabled>
                                    <i class="fa fa-shopping-cart"></i>Hết hàng
                                </button>
                                @endif
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
    </a>
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
                            <img src="{{URL::to('/upload/products/'.$product->product_image)}}" alt="" />
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
                                    <img width="250" height="250" src="{{URL::to('/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                                    <h2>{{number_format($product->price).' ₫'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
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
                                    <img width="250" height="250" src="{{asset('/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
                                    <h2>{{number_format($product->price).' ₫'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
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