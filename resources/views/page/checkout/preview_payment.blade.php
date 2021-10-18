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
			<?php
				$shipping_detail = Session::get('shipping_detail');
				$customer_id = Session::get('customer_id');
			?>
			<div class="review-payment">
				<h2>Xem lại và thanh toán</h2>
			</div>
			<a class="btn btn-back" href="{{URL::to('/thong-tin-giao-hang/'.$customer_id)}}">Trở lại</a>
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<div class="table-responsive shipping_info">
								<table class="table table-condensed">
									<thead>
										<tr class="shipping_menu">
											<td>Thông tin giao hàng</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
											@foreach($shipping_detail as $key => $shipping)
							                		<h4>{{$shipping->customer_name}} - {{$shipping->customer_phone}}</h4>
													<p>{{$shipping->shipping_address}}</p>
													<p> {{$shipping->customer_email}}</p>
							                @endforeach
								            </td>
								        </tr>
								    </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
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
								<input class="cart_quantity_input" type="number" name="itemQuantity" value="{{$cart_item->qty}}" autocomplete="off" size="2" disabled>
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
				
				<form action="{{URL::to('/dat-hang')}}" method="post">
					{{csrf_field()}}
					<label for="customerNote">Ghi chú</label>
					<textarea name="customerNote" placeholder="  Nhập ghi chú cho đơn hàng của bạn" rows="5"></textarea>
					<h4>Phương thức thanh toán</h4>
					<select class="form-control input-sm m-bot15" name="paymentMethod" required>
						@foreach($payment_methods as $key => $payment_method)
	                    <option value="{{$payment_method->payment_id}}" style="height: 150px; font-size: 14px;">{{$payment_method->payment_method}}</option>
	                    @endforeach
	                </select>
	                <input type="hidden" name="orderPaid" value="0">
	                <button type="submit" class="btn btn-default btn-order">Đặt hàng</button>
	            </form>
			</div>
		</div>
	</section> <!--/#cart_items-->
@endsection