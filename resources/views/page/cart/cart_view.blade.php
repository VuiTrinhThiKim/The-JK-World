@extends('layout_view')

@section('content')
<section id="cart_items">
	<div class="container" style="width:100%;">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
			  <li class="active">Giỏ hàng</li>
			</ol>
		</div>
		<div class="table-responsive cart_info">
			<?php
				$cart_content = Cart::content();
			?>
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Sản phẩm</td>
						<td class="description"></td>
						<td class="price">Giá</td>
						<td class="quantity">Số lượng</td>
						<td class="total">Thành tiền</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($cart_content as $cart_item)
					<tr>
						<td class="cart_product">
							<a href="#"><img src="{{URL::to('/public/upload/products/'.$cart_item->options->image)}}" alt="{{$cart_item->image}}" width="60" height="60" /></a>
						</td>
						<td class="cart_description">
							<h4><a href="">{{$cart_item->name}}</a></h4>
							<!--<p>							</p>-->
						</td>
						<td class="cart_price">
							<p>{{number_format($cart_item->price).' ₫'}}</p>
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								<a class="cart_quantity_up" href=""> + </a>
								<input class="cart_quantity_input" type="text" name="quantity" value="{{$cart_item->qty}}" autocomplete="off" size="2">
								<a class="cart_quantity_down" href=""> - </a>
							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">{{Cart::subtotal().' ₫'}}</p>
						</td>
						<td class="cart_delete">
							<a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')"  class="cart_quantity_delete" href="{{URL::to('/xoa-san-pham-khoi-gio-hang/'.$cart_item->rowId)}}"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section> <!--/#cart_items-->
<section id="do_action">
	<div class="container" style="width:100%;">
		<div class="heading">
			<h3>Thanh toán</h3>
			<p>Ví dụ</p>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="chose_area">
					<ul class="user_option">
						<li>
							<input type="checkbox">
							<label>Dùng mã giảm giá</label>
						</li>
						<li>
							<input type="checkbox">
							<label>Dùng Gift Voucher</label>
						</li>
						<li>
							<input type="checkbox">
							<label>Estimate Shipping & Taxes</label>
						</li>
					</ul>
					<ul class="user_info">
						<li class="single_field">
							<label>Tỉnh/Thành phố:</label>
							<select>
								<option>United States</option>
								<option>Bangladesh</option>
								<option>UK</option>
								<option>India</option>
								<option>Pakistan</option>
								<option>Ucrane</option>
								<option>Canada</option>
								<option>Dubai</option>
							</select>
							
						</li>
						<li class="single_field">
							<label>Quận/Huyện:</label>
							<select>
								<option>Select</option>
								<option>Dhaka</option>
								<option>London</option>
								<option>Dillih</option>
								<option>Lahore</option>
								<option>Alaska</option>
								<option>Canada</option>
								<option>Dubai</option>
							</select>
						
						</li>
						<li class="single_field">
							<label>Phường/Xã:</label>
							<select>
								<option>Select</option>
								<option>Dhaka</option>
								<option>London</option>
								<option>Dillih</option>
								<option>Lahore</option>
								<option>Alaska</option>
								<option>Canada</option>
								<option>Dubai</option>
							</select>
						
						</li>
					</ul>
					<a class="btn btn-default update" href="">Get Quotes</a>
					<a class="btn btn-default check_out" href="">Continue</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="total_area">
					<ul>
						<li>Tổng<span>{{Cart::subtotal().' ₫'}}</span></li>
						<li>VAT (5%)<span>{{Cart::tax().' ₫'}}</span></li>
						<li>Phí vận chuyển<span>Free</span></li>
						<li>Thành tiền<span>{{Cart::total().' ₫'}}</span></li>
					</ul>
						<a class="btn btn-default update" href="">Cập nhật</a>
						<a class="btn btn-default check_out" href="">Thanh toán</a>
				</div>
			</div>
		</div>
	</div>
</section><!--/#do_action-->
@endsection