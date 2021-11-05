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
            <section id="order_items">
            <div class="col-sm-12">
                <div class="content_margin">
                    <div class="table-responsive order_info">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="order_menu">
                                    <td class="id">Mã đơn</td>
                                    <td class="date" style='width:12%;'>Ngày đặt</td>
                                    <td class="method">Phương thức thanh toán</td>
                                    <td class="total">Tổng</td>
                                    <td class="paid">Đã trả</td>
                                    <td class="remain">Còn lại</td>
                                    <td class="status">Trạng thái đơn hàng</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders->isNotEmpty())
                                @foreach($orders as $key => $order)
                                <tr>
                                    <td class="order_id"style="width: 10%;">
                                       <p>{{$order->order_id}}</p>
                                    </td>
                                    <td class="order_date">
                                        <p>{{$order->created_at}}</p>
                                    </td>
                                    <td class="payment_method">
                                        <p>{{$order->payment_method}}</p>
                                    </td>
                                    <td class="total">
                                        <span>
                                            <span>{{number_format($order->order_total).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="order_paid">
                                        <span>
                                            <span>{{number_format($order->order_paid).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="order_remain">
                                        <span>
                                            <span>{{number_format($order->order_total - $order->order_paid).' ₫'}}</span>
                                        </span>
                                    </td>
                                    <td class="order_status">
                                        <p>{{$order->status_name}}</p>
                                    </td>
                                    <td class="order_view">
                                        <button type="button" class="cart_quantity_delete" data-toggle="modal" data-target="#orderDetailsModal{{$order->order_id}}">
                                          <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        </div>       
    </div>
</div><!--/category-tab-->
@if($orders->isNotEmpty())
@foreach($orders as $key => $order)
<div class="modal fade" id="orderDetailsModal{{$order->order_id}}" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel{{$order->order_id}}" aria-hidden="true">
      <div class="modal-dialog modal-resize" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="orderDetailsModalLabel{{$order->order_id}}">Thông tin đơn hàng #{{$order->order_id}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <section id="order_items">
            <div class="col-sm-12">
                <div class="content_margin">
                    <div class="table-responsive order_info ">
                        <table class="table table-condensed">
                            <thead>
                                <tr class="order_menu">
                                    <td class="id">Mã SP</td>
                                    <td class="date">Sản phẩm</td>
                                    <td class="date"></td>
                                    <td class="method">Giá</td>
                                    <td class="total">Số lượng</td>
                                    <td class="total">Tạm tính</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_details as $key => $detail)
                                @if($detail->order_id == $order->order_id)
                                <tr>
                                    <td class="order_id"style="width: 10%;">
                                       <p>{{$detail->product_id}}</p>
                                    </td>
                                    <td class="order_date">
                                        <a href=""><img src="{{asset('/upload/products/'.$detail->product_image)}}" alt="{{$detail->product_name}}" width="85px" height="85px"></a>
                                    </td>
                                    <td class="payment_method">
                                        <p>{{$detail->product_name}}</p>
                                    </td>
                                    <td class="total">
                                        <p>
                                            <span>{{number_format($detail->price).' ₫'}}</span>
                                        </p>
                                    </td>
                                    <td class="order_status">
                                        <p>{{$detail->product_sale_qty}}</p>
                                    </td>
                                    <td class="order_total">
                                        <p>{{number_format($detail->product_sale_qty * $detail->price).' ₫'}}</p>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <tr class="row-total">
                                    <td colspan="4">&nbsp;</td>
                                    <td colspan="2">
                                        <table class="table table-condensed">
                                            <tr>
                                                <td>Tổng</td>
                                                <td>{{number_format($order->order_total).' ₫'}}</td>
                                            </tr>
                                            <tr class="shipping-cost">
                                                <td>Phí vận chuyển</td>
                                                <td>Miễn phí</td>                                       
                                            </tr>
                                            <tr>
                                                <td>Đã thanh toán</td>
                                                <td><span>{{number_format($order->order_paid).' ₫'}}</span></td>
                                            </tr>
                                            <tr>
                                                <td>Thành tiền</td>
                                                <td class='order_total'>
                                                    <span>{{number_format($order->order_total - $order->order_paid).' ₫'}}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @if($order->order_paid > 0 || $order->status_id != 1)
        <div class="modal-thanks">
            <p>Cảm ơn quý khách đã đặt hàng tại TheJKWorld!</p>
            <div class='modal-print'>
                <a href="#" class="btn btn-primary">In hóa đơn</a>
            </div>
        </div>
        @else
        <div class="modal-thanks">
            <p>Cảm ơn quý khách đã đặt hàng tại TheJKWorld!!<br>
            Quý khách có thể thực hiện hủy đơn đối với các đơn hàng chưa thanh toán!</p>
            <div>
                <a href="#" class="btn btn-primary">In hóa đơn</a>
                <div class="order_view">
                    <a class="cart_quantity_delete" href="#">Hủy đơn hàng</a>
                </div>
            </div>
        </div>
        @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-shipping-save" data-dismiss="modal">Đóng</button>
          </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection