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

			<?php
				$customer_id = Session::get('customer_id');
			?>
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<div class="chosse-shipping">
								<h2>Chọn địa chỉ giao hàng</h2>
								
							</div>
							<div class="add-new-shipping">
									<button type="button" class="btn btn-shipping-save" data-toggle="modal" data-target="#addNewShippingModal">
								  Thêm thông tin giao hàng
								</button>
								</div>
							<!-- Modal -->
							<div class="modal fade" id="addNewShippingModal" tabindex="-1" role="dialog" aria-labelledby="addNewShippingModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="addNewShippingModalLabel">Thêm địa chỉ mới</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <div class="form-one">
										<form action="{{URL::to('/luu-thong-tin-giao-hang')}}" method="post">
											{{csrf_field()}}
											<input type="hidden" name="customerId" value="{{$customer_id}}">
											<label for="customerEmail">Email</label>
											<input type="email"name="customerEmail" placeholder="example@gmail.com">
											<label for="customerFullName">Họ và tên</label>
											<input type="text" name="customerFullName" placeholder="Nguyễn Văn A">
											<label for="customerAddress">Địa chỉ</label>
											<input type="text" name="customerAddress"placeholder="97 Võ Văn Tần, phường 6, quận 3, TP. HCM">
											<label for="customerPhone">Điện thoại</label>
											<input type="text"name="customerPhone" placeholder="0123456789">
											<input type="hidden" name="isDefault" value="0">
											<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu thông tin giao hàng</button>
										</form>
									</div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-shipping-save" data-dismiss="modal">Đóng</button>
							      </div>

							    </div>
							  </div>
							</div>
							<a class="btn btn-back" href="{{URL::to('/xem-gio-hang')}}">Trở lại</a>
							@foreach($shipping_default as $key => $shipping)
								<div class="position-content">
								<div class="col-sm-1">
									<div class="custom-control custom-radio">
										<label class="custom-control-label" for="customRadio" style="display: none;">Toggle this custom radio</label>
									  	<input class="custom-control-input" type="radio" id="shippingId_{{$shipping->shipping_id}}" name="customRadio" checked="checked" onclick="changeShippingIdChecked('shippingId_{{$shipping->shipping_id}}')">
									</div>
					            </div>
					            <div class="col-sm-11">
				                	<div class="shipping_content">
				                		<h4>{{$shipping->customer_name}} - {{$shipping->customer_phone}}
				                			<div class="default_address">[Địa chỉ mặc định]</div></h4>
										<p>{{$shipping->shipping_address}}</p>
										<p> {{$shipping->customer_email}}</p>
									</div>
								</div>
			                </div>
			                @endforeach
			                @foreach($shipping_not_default as $key => $shipping)
								<div class="position-content">
								<div class="col-sm-1">
									<div class="custom-control custom-radio">
										<label class="custom-control-label" for="customRadio" style="display: none;">Toggle this custom radio</label>
									  <input class="custom-control-input" id="shippingId_{{$shipping->shipping_id}}" type="radio" name="customRadio" onclick="changeShippingIdChecked('shippingId_{{$shipping->shipping_id}}')">
									</div>
					            </div>
					            <div class="col-sm-11">
				                	<div class="shipping_content">
				                		<h4>{{$shipping->customer_name}} - {{$shipping->customer_phone}}</h4>
										<p>{{$shipping->shipping_address}}</p>
										<p> {{$shipping->customer_email}}</p>
									</div>
								</div>
			                </div>
                			@endforeach

                			<form action="{{URL::to('/chon-dia-chi-giao-hang')}}" method="post">
                				{{csrf_field()}}
                				@foreach($shipping_default as $key => $shipping)
	                			<input type="hidden" id="shippingIdSelected" name="shippingIdSelected" value="{{$shipping->shipping_id}}">
	                			@endforeach
	                			<button class="btn btn-primary" type="submit">Tiếp tục</button>
                			</form>
						</div>
						
					</div>			
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->
@endsection