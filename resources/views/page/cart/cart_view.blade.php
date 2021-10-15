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
		@if(Cart::content()->isNotEmpty())
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
					@foreach($cart_content as $key => $cart_item)
					<tr>
						<td class="cart_product"style="width: 10%;>
							<a href="#"><img src="{{asset('/upload/products/'.$cart_item->options->image)}}" alt="{{$cart_item->image}}" width="60" height="60" /></a>
						</td>
						<td class="cart_description" style="width: 30%;">
							<h4><a href="">{{$cart_item->name}}</a></h4>
							<!--<p>							</p>-->
						</td>
						<td class="cart_price">
							<p>{{number_format($cart_item->price).' ₫'}}</p>
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								<form action="{{URL::to('/cap-nhat-so-luong/'.$cart_item->rowId)}}" method="post">
									{{csrf_field()}}
									<input class="cart_quantity_input" type="number" name="itemQuantity" min="1" max="10" value="{{$cart_item->qty}}" autocomplete="off" size="2">
									<input type="hidden" name="rowId" value="{{$cart_item->rowId}}">
									<button type="submit" class="btn-save"><i class="fa fa-save"></i></button>
								</form>
							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">
								<?php
									$subtotal = $cart_item->price * $cart_item->qty;
									echo number_format($subtotal).' ₫';
								?>
							</p>
						</td>
						<td class="cart_delete">
							<a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')"  class="cart_quantity_delete" href="{{URL::to('/xoa-san-pham-khoi-gio-hang/'.$cart_item->rowId)}}"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<h2>Bạn chưa có sản phẩm nào trong giỏ hàng</h2>

		@endif
		<!--<div>
			<button>Xóa giỏ hàng</button>
		</div>
	-->
	</div>
</section> <!--/#cart_items-->
@if(Cart::content()->isNotEmpty())
<section id="do_action">
	<div class="container" style="width:100%;">
		<div class="heading">
			<h3>Thanh toán</h3>
		</div>
		<div class="row">
			<!--
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
								
							</select>
							
						</li>
						<li class="single_field">
							<label>Quận/Huyện:</label>
							<select>
								<option>Select</option>
								
							</select>
						
						</li>
						<li class="single_field">
							<label>Phường/Xã:</label>
							<select>
								<option>Select</option>
								
							</select>
						
						</li>
					</ul>
					<a class="btn btn-default update" href="">Get Quotes</a>
					<a class="btn btn-default check_out" href="">Continue</a>
				</div>
			</div>
			<div class="col-sm-6">-->
			<div class="col-sm-12">
				<div class="total_area">
					<ul>
						<li>Tổng (đã bao gồm VAT)<span>{{Cart::subtotal().' ₫'}}</span></li>
						<li>Phí vận chuyển<span>Miễn phí</span></li>
						<li>Thành tiền<span>{{Cart::total().' ₫'}}</span></li>
					</ul>
						<!--<a class="btn btn-default update" href="">Cập nhật</a>-->
						<?php
                            $customer_id = Session::get('customer_id');
                            if ($customer_id != null) {
                        ?>
                                <a class="btn btn-default check_out" href="{{URL::to('/thong-tin-giao-hang/'.$customer_id)}}">Tiếp tục</a>
                        <?php
                            }
                            else {
                        ?>
                                <a class="btn btn-default check_out" href="{{URL::to('/login-to-checkout')}}">Thanh toán</a>
                        <?php
                            }
                        ?>
						
				</div>
			</div>
		</div>
	</div>
</section><!--/#do_action-->
@endif
@endsection