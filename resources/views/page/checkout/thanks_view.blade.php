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
				<h2>Đặt hàng thành công</h2>

				<p>Xin chào <b>{{$customer_name}}</b>! Cảm ơn bạn đã mua sắm tại The JK World.<br>
					<b>Mã đơn hàng của bạn là {{$order_id}}</b>. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!Trở về <a href="{{URL::to('/trang-chu')}}">trang chủ</a>
				</p>
			</div>
		</div>
	</section> <!--/#cart_items-->
@endsection