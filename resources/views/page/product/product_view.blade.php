@extends('layout_view')

@section('content')

@foreach($product_details as $key => $product)
<div class="product-details"><!--product-details-->
	<div class="col-sm-5">
		<div class="view-product">
			<img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
			<h3>ZOOM</h3>
		</div>
		<div id="similar-product" class="carousel slide" data-ride="carousel">
			
			  <!-- Wrapper for slides -->
			    <div class="carousel-inner">
					<div class="item active">
					  <a href=""><img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt=""></a>
					</div>
					<div class="item">
					  <a href=""><img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt=""></a>
					</div>
					<div class="item">
					  <a href=""><img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt=""></a>
					</div>
					
				</div>

			  <!-- Controls -->
			  <a class="left item-control" href="#similar-product" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			  </a>
			  <a class="right item-control" href="#similar-product" data-slide="next">
				<i class="fa fa-angle-right"></i>
			  </a>
		</div>

	</div>
	<div class="col-sm-7">
		<div class="product-information"><!--/product-information-->
			<img src="{{asset('public/frontend/images/new.jpg')}}" class="newarrival" alt="" />
			<h2>{{$product->product_name}}</h2>
			<p>Mã sản phẩm: {{$product->product_id}}</p>
			<img src="images/product-details/rating.png" alt="" />
			<span>
				<span>{{number_format($product->price).' ₫'}}</span>
			</span>
			<span>
				<label>Số lượng:</label>
				<input type="number" min="1" max="4" value="3" />
				<button type="button" class="btn btn-fefault cart">
					<i class="fa fa-shopping-cart"></i>
					Thêm vào giỏ hàng
				</button>
			</span>
			<p><b>Brand:</b> {{$product->brand_name}}</p>
			<p><b>Danh mục:</b> {{$product->category_name}}</p>
			<p><b>Trạng thái:</b> In Stock</p>
			<p><b>Tình trạng sản phẩm:</b> New</p>
			
			<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
		</div><!--/product-information-->
	</div>
</div><!--/product-details-->
@endforeach
<div class="category-tab shop-details-tab"><!--category-tab-->
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#description" data-toggle="tab">Mô tả</a></li>
			<li><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
			<li><a href="#brand" data-toggle="tab">Thông tin brand</a></li>
			<li><a href="#tag" data-toggle="tab">Tag</a></li>
			<li><a href="#reviews" data-toggle="tab">Đánh giá (5)</a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="description" >
			<div class="col-sm-12">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo">
							<img src="images/home/gallery1.jpg" alt="" />
							<h2>Mô tả:</h2>
							<p>{{$product->product_description}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="details" >
			<div class="col-sm-12">
				<div class="product-image-wrapper">
					<div class="single-products">
						<textarea rows=9 class="form-control cke_inner cke_top" id="productContent" name="productContent" disabled>{{$product->content}}</textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="brand" >
			<div class="col-sm-12">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo">
							<img src="images/home/gallery1.jpg" alt="" />
							<h2>Brand</h2>
							<p>{{$product->brand_description}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="tag" >
			<div class="col-sm-3">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo text-center">
							<img src="images/home/gallery4.jpg" alt="" />
							<h2>$56</h2>
							<p>Easy Polo Black Edition</p>
							<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="tab-pane fade" id="reviews" >
			<div class="col-sm-12">
				<ul>
					<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
					<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
					<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
				</ul>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<p><b>Write Your Review</b></p>
				
				<form action="#">
					<span>
						<input type="text" placeholder="Your Name"/>
						<input type="email" placeholder="Email Address"/>
					</span>
					<textarea name="" ></textarea>
					<b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
					<button type="button" class="btn btn-default pull-right">
						Submit
					</button>
				</form>
			</div>
		</div>
		
	</div>
</div><!--/category-tab-->
<div class="recommended_items"><!--recommended_items-->
    <h2 class="title text-center">Sản phẩm gợi ý</h2>
    
    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active"> 
            	@foreach($related_products as $key => $product)  
                <div class="col-sm-4">
                	<a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
	                    <div class="product-image-wrapper">
	                        <div class="single-products">
	                            <div class="productinfo text-center">
	                                <img src="{{URL::to('/public/upload/products/'.$product->product_image)}}" alt="{{$product->product_image}}" />
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