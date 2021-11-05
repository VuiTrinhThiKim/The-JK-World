@extends('admin_layout_view')

@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách đơn hàng chờ xử lí
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <form action="{{URL::to('/admin/order/filter')}}">
          {{csrf_field()}}
          <select class="input-sm form-control w-sm inline v-middle" name="filter">
            <option value="0">Xem tất cả</option>
            <option value="1">Sắp xếp theo ID tăng</option>
            <option value="2">Sắp xếp theo ID giảm</option>
            <option value="3">Sắp xếp theo tên từ A-Z</option>
            <option value="4">Sắp xếp theo tên từ Z-A</option>
          </select>
          <button class="btn btn-sm btn-default" type="submit">Áp dụng</button>
        </form>               
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <form action="{{URL::to('/admin/order/search')}}" method="get">
            {{csrf_field()}}
          <div class="input-group">
            <input type="text" name="keywords" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="submit">Tìm!</button>
            </span>
          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <?php 
        $statusOrder_message = Session::get('messOrder');
        if($statusOrder_message) {
            echo '<span class="status_alert">'.$statusOrder_message.'</span>';
            Session::put('messOrder', null);
        }
        $order_role = Session::get('order_role');
        $ad_usename = Session::get('ad_usename');
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:5%;">ID</th>
            <th style="width:15%;">Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Phương thức thanh toán</th>
            <th>Tổng</th>
            <th>Đã trả</th>
            <th>Còn lại</th>
            <th>Trạng thái đơn hàng</th>
            <th style="width:2%;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $key => $order)
          <tr>
            <td>{{$order->order_id}}</td>
            <td>{{$order->username}}</td>
            <td>{{$order->customer_phone}}</td>
            <td>{{$order->payment_method}}</td>
            <td>{{$order->order_total}}</td>
            <td>{{$order->order_paid}}</td>
            <td>
              {{$order->order_total - $order->order_paid}}
            </td>
            <td>{{$order->status_name}}</td>
            <td>
              <button class="btn btn-default btn-success" type="button">Xác nhận</button>
            </td>
            <td>

              <a href="{{URL::to('/admin/order/edit/'.$order->order_id)}}" class="edit-product" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-edit"></i>
              </a>
              <a onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')" href="{{URL::to('/admin/order/delete/'.$order->order_id)}}" class="delete-product" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <!--Pagination-->
      {{ $orders->links('admin.pagination') }}
    </footer>
  </div>
</div>
@endsection