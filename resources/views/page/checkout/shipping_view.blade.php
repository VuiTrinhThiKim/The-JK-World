@extends('layout_view')

@section('content')
	<section id="cart_items">
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/trang-chu')}}">Trang chủ</a></li>
				  <li class="active">Thông tin giao hàng</li>
				</ol>
			</div><!--/breadcrums-->

			<!--<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div>/register-req-->
			<?php
				$customer_id = Session::get('customer_id');
			?>
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<h2 class="title text-center">Địa chỉ giao hàng</h2>
							@foreach($shipping_default as $key => $shipping)
				            <div class="position-content">
			                	<div class="shipping_info">
			                	<address>
									<h4>{{$shipping->customer_name}} - [Địa chỉ mặc định]</h4>
									<p>{{$shipping->customer_phone}}</p>
									<p>{{$shipping->shipping_address}}</p>
									<p>{{$shipping->customer_email}}</p>
								</address>	
								</div>
			                </div>
			                @endforeach
			                @foreach($shipping_not_default as $key => $shipping)
			                <div class="position-content">
			                	<div class="shipping_info">
			                	<address>
									<h4>{{$shipping->customer_name}}</h4>
									<p>{{$shipping->customer_phone}}</p>
									<p>{{$shipping->shipping_address}}</p>
									<p>{{$shipping->customer_email}}</p>
								</address>	
								</div>
			                </div>
                			@endforeach
						</div>
					</div>			
				</div>
				<div class="row" style="margin-top: 15px;">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<h2 class="title text-center">Thêm địa chỉ giao hàng</h2>
							<div class="form-one">
								<form action="{{URL::to('/luu-thong-tin-giao-hang')}}" method="post">
									{{csrf_field()}}
									<input type="hidden" name="customerId" value="{{$customer_id}}">
									<label for="customerEmail">Email</label>
									<input type="email"name="customerEmail" placeholder="Email*">
									<label for="customerFullName">Họ và tên</label>
									<input type="text" name="customerFullName" placeholder="Họ và tên">
									<label for="customerAddress">Địa chỉ</label>
									<input type="text" name="customerAddress"placeholder="Địa chỉ">
									<label for="customerPhone">Điện thoại</label>
									<input type="text"name="customerPhone" placeholder="VD: 0123456789">
									<label for="customerNote">Ghi chú</label>
									<textarea name="customerNote" placeholder="  Nhập ghi chú cho đơn hàng của bạn" rows="5"></textarea>
									<button type="submit" class="btn btn-default btn-save shipping-save"><i class="fa fa-save"></i> Lưu thông tin giao hàng</button>
								</form>
							</div>
						</div>
					</div>			
				</div>
			</div>
			<!--<div class="review-payment">
				<h2>Xem lại và thanh toán</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
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
						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/three.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>$59</td>
									</tr>
									<tr>
										<td>Exo Tax</td>
										<td>$2</td>
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>										
									</tr>
									<tr>
										<td>Total</td>
										<td><span>$61</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="payment-options">
				<span>
					<label><input type="checkbox"> Direct Bank Transfer</label>
				</span>
				<span>
					<label><input type="checkbox"> Check Payment</label>
				</span>
				<span>
					<label><input type="checkbox"> Paypal</label>
				</span>
			</div>-->
		</div>
	</section> <!--/#cart_items-->
@endsection