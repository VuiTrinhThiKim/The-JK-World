@extends('layout_view')

@section('content')
	<section id="cart_items">
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="review-payment">
				<h2>Xem lại và thanh toán</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<?php
						$cart_content = Cart::content();
					?>
					<thead>
						<tr class="cart_menu">
							<td class="image">Sản phẩm</td>
							<td class="description"></td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tạm tính</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($cart_content as $key => $cart_item)
					<tr>
						<td class="cart_product">
							<a href="#"><img src="{{URL::to('/public/upload/products/'.$cart_item->options->image)}}" alt="{{$cart_item->image}}" width="60" height="60" /></a>
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
									<button type="submit" class="btn btn-default btn-save"><i class="fa fa-save"></i></button>
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
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Tổng <br>(đã bao gồm VAT)</td>
										<td>{{Cart::subtotal().' ₫'}}</td>
									</tr>
									<tr class="shipping-cost">
										<td>Phí vận chuyển</td>
										<td>Free</td>										
									</tr>
									<tr>
										<td>Thành tiền</td>
										<td><span>{{Cart::total().' ₫'}}</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="payment-options">
				<h4>Phương thức thanh toán</h4>
				<form action="{{URL::to('/dat-hang')}}" method="post">
					{{csrf_field()}}
					<select class="form-control input-sm m-bot15" name="paymentMethod" required>
	                    <option value="1" style="height: 150px; font-size: 14px;">Thanh toán khi nhận hàng</option>
	                    <option value="2" style="height: 150px; font-size: 14px;">Thanh toán qua thẻ ATM</option>
	                    <option value="3" style="height: 150px; font-size: 14px;">Thanh toán qua thẻ ghi nợ nội địa</option>
	                </select>
	                <button type="submit" class="btn btn-default btn-order">Đặt hàng</button>
	            </form>
			</div>
		</div>
	</section> <!--/#cart_items-->
@endsection