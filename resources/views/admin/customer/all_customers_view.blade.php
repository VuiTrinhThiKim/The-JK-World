@extends('admin_layout_view')

@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách khách hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <form action="{{URL::to('/admin/customer/filter')}}">
          {{csrf_field()}}
          <select class="input-sm form-control w-sm inline v-middle" name="filter">
            <option value="0">Xem tất cả</option>
            <option value="1">Sắp xếp theo tên từ A-Z</option>
            <option value="2">Sắp xếp theo tên từ Z-A</option>
            <option value="3">Đang hiển thị trên web</option>
            <option value="4">Đang bị ẩn khỏi web</option>
          </select>
          <button class="btn btn-sm btn-default" type="submit">Áp dụng</button>
        </form>          
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <form action="{{URL::to('/admin/customer/search')}}" method="get">
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
    <div class="table-responsive">
      <?php 
        $status_message = Session::get('mess');
        if($status_message) {
            echo '<div class="status_alert">'.$status_message.'</div>';
            Session::put('mess', null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:5%;">ID</th>
            <th>Tên đăng nhập</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($customers as $key => $customer)
          <tr>
            <td>{{ $customer->customer_id}}</td>
            <td>{{ $customer->username}}</td>
            <td>{{ $customer->first_name}}</td>
            <td>{{ $customer->phone}}</td>
            <td>{{ $customer->email}}</td>
            <td>
              <a href="{{URL::to('/admin/customer/edit/'.$customer->customer_id)}}" class="edit-customer" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-edit"></i>
              </a>
              <a a onclick="return confirm('Bạn có chắc chắn muốn xóa brand này?')" href="{{URL::to('/admin/customer/delete/'.$customer->customer_id)}}" class="delete-customer" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      
      {{ $customers->links('admin.pagination') }}

    </footer>
  </div>
</div>
@endsection