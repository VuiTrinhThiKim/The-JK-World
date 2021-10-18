@extends('admin_layout_view')

@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách quản trị viên
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <form action="{{URL::to('/admin/member/filter')}}">
          {{csrf_field()}}
          <select class="input-sm form-control w-sm inline v-middle" name="filter">
            <option value="0">Xem tất cả</option>
            <option value="1">Sắp xếp theo ID tăng</option>
            <option value="2">Sắp xếp theo ID giảm</option>
            <option value="3">Sắp xếp theo tên từ A-Z</option>
            <option value="4">Sắp xếp theo tên từ Z-A</option>
            <option value="5">Quản lí - Manager</option>
            <option value="6">Nhân viên - Staff</option>
          </select>
          <button class="btn btn-sm btn-default" type="submit">Áp dụng</button>
        </form>               
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <form action="{{URL::to('/admin/member/search')}}" method="get">
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
        $admin_role = Session::get('admin_role');
        $ad_usename = Session::get('ad_usename');
        $admins = $result;
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:5%;">ID</th>
            <th style="width:15%;">Tên đăng nhập</th>
            <th>Ảnh đại diện</th>
            <th>Tên</th>
            <th>Họ</th>
            <th>Số điện thoại</th>
            <th>Giới tính</th>
            <th>Loại tài khoản</th>
            <th style="width:2%;"></th>
          </tr>
        </thead>
        <tbody>
          @if($result->isNotEmpty())
          @foreach($result as $key => $admin)
          <tr>
            <td>{{$admin->admin_id}}</td>
            <td>{{$admin->username}}</td>
            <td>
                <img src="{{asset('/upload/avatar/admin/'.$admin->avatar)}}" url="{{$admin->avatar}}" width="80" height="80"></span>
            </td>
            <td>{{$admin->first_name}}</td>
            <td>{{$admin->last_name}}</td>
            <td>{{$admin->phone}}</td>
            <td>
              @if($admin->gender == 0)
              Nam
              @else
              Nữ
              @endif
            </td>
            <td>
            	@if($admin->role_id == 1)
            	Manager
            	@else
            	Staff
            	@endif
            </td>
            <td>
              @if($admin_role == '1' || $ad_usename == $admin->username)
              <a href="{{URL::to('/admin/member/edit/'.$admin->admin_id)}}" class="edit-product" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-edit"></i>
              </a>
              <a onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')" href="{{URL::to('/admin/member/delete/'.$admin->user_id)}}" class="delete-product" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
              @endif
            </td>
          </tr>
          @endforeach
          @else
          <?php
            $statusMember_message = Session::get('messMember');
            if($statusMember_message) {
                echo '<div class="status_alert">'.$statusMember_message.'</div>';
                Session::put('messMember', null);
            }
          ?>
          @endif
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <!--Pagination-->
      {{ $admins->links('admin.pagination') }}
    </footer>
  </div>
</div>
@endsection