@extends('layout_view')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <h2 class="title text-center">Thông tin tài khoản</h2> 
            <div class="panel-body">
                @foreach($customer as $key => $customer)
                <div class="position-content">
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
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab">Thông tin cá nhân</a></li>
            <li><a href="#address" data-toggle="tab">Địa chỉ nhận hàng</a></li>
            <li><a href="#orders" data-toggle="tab">Đơn đặt hàng</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="profile" >
            <div class="col-sm-12">
                <div class="content_margin">
                    
                   <div class="form-one">
                        <form action="{{URL::to('/customer/member/edit')}}" role="form" method="post">
                            {{csrf_field() }}
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="address" >
            <div class="col-sm-12">
                <div class="content_margin">
                    <div class="row">
                        <section class="panel">
                            
                            <div class="panel-body">
                                @foreach($shipping_default as $key => $shipping)
                                <div class="position-content">
                                    <div class="shipping_info">
                                    <address>
                                        <h4>{{$shipping->customer_name}} - {{$shipping->customer_phone}} <span class="default_address">[Địa chỉ mặc định]</span></h4>
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
                                        <h4>{{$shipping->customer_name}} - {{$shipping->customer_phone}}</h4>
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
            </div>
        </div>
        <div class="tab-pane fade" id="orders" >
            <div class="col-sm-12">
                <div class="content_margin">
                    <div class="table-responsive cart_info">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="cart_menu">
                                    <td class="image">Mã đơn hàng</td>
                                    <td class="description">Ngày đặt</td>
                                    <td class="total">Phương thức thanh toán</td>
                                    <td class="price">Tổng</td>
                                    <td class="quantity">Đã trả</td>
                                    <td class="total">Còn lại</td>
                                    <td class="total">Trạng thái đơn hàng</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td class="cart_product"style="width: 10%;">
                                       <p>{{$order->order_id}}</p>
                                    </td>
                                    <td class="cart_description">
                                        <p>{{$order->created_at}}</p>
                                    </td>
                                    <td class="total">
                                        <p>{{$order->payment_method}}</p>
                                    </td>
                                    <td class="cart_price">
                                        <span>
                                            <span>{{number_format($order->order_total).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="cart_quantity">
                                        <span>
                                            <span>{{number_format($order->order_paid).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="cart_total">
                                        <span>
                                            <span>{{number_format($order->order_total - $order->order_paid).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="cart_quantity">
                                        <p>{{$order->order_status}}</p>
                                    </td>
                                    <td class="cart_delete">
                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')"  class="cart_quantity_delete" href="{{URL::to('/xoa-san-pham-khoi-gio-hang/'.$order->rowId)}}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</div><!--/category-tab-->

<!--Shipping-->


<div class="row">
    <div class="col-lg-12">
        
    </div>
</div>
@endsection