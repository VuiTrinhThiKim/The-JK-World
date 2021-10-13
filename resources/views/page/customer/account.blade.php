@extends('layout_view')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <h2 class="title text-center">Thông tin tài khoản</h2> 
            <div class="panel-body">
                @foreach($customer as $key => $customer)
                <div class="position-content">
                    <form action="{{URL::to('/customer/member/edit')}}" role="form" method="post">
                    {{csrf_field() }}
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <!--<img src="{{asset('uplocustomer/avatar/customer/'.$customer->avatar)}}" alt="customer_avatar" width="250" height="250">-->
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="customer_id">Mã khách hàng</label>
                                <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{$customer->customer_id}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{$customer->username}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="firstName">Tên</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$customer->first_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="lastName">Họ</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{$customer->last_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="customerDOB">Ngày sinh</label>
                                <input type="date" class="form-control" id="customerDOB" name="customerDOB" value="{{$customer->dob}}" >
                            </div>
                            <div class="form-group">
                                <label for="customerGender">Giới tính</label>
                                <select type="date" class="form-control" id="customerGender" name="customerGender">
                                    @if($customer->gender == 0)
                                    <option value="0" selected>Nam</option>
                                    <option value="1">Nữ</option>
                                    @else
                                    <option value="0">Nam</option>
                                    <option value="1" selected>Nữ</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="customerEmail">Email</label>
                                <input type="text" class="form-control" id="customerEmail" name="customerEmail" value="{{$customer->email}}">
                            </div>
                            <div class="form-group">
                                <label for="customerPhone">Số điện thoại</label>
                                <input type="text" class="form-control" id="customerPhone" name="customerPhone" value="{{$customer->phone}}">
                            </div>
                            <div class="form-group update-avt">
                                <label for="avatar">Đổi ảnh đại diện</label>
                                <input type="file" name="avatar">
                                
                            </div>
                            <div class="form-group">
                                <button type="submit" name="editCustomer" class="btn btn-send">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

<!--Shipping-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-hecustomering">
            Địa chỉ nhận hàng
            </header>
            <div class="panel-body">
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
        </section>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-hecustomering">
            Đơn đặt hàng
            </header>
            <div class="panel-body">
            	@foreach($orders as $key => $order)
                <div class="position-content">
                	<p>{{$order->order_id}}</p>
            	</div>
            	@endforeach
            </div>
        </section>
    </div>
</div>
@endsection