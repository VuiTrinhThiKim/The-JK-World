@extends('admin_layout_view')

@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách các brand
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <form action="{{URL::to('/admin/brand/filter')}}">
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
        <form action="{{URL::to('/admin/brand/search')}}" method="get">
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
        $statusBrand_message = Session::get('messBrand');
        if($statusBrand_message) {
            echo '<div class="status_alert">'.$statusBrand_message.'</div>';
            Session::put('messBrand', null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:5%;">ID</th>
            <th style="width:30%;">Tên brand</th>
            <th>Thông tin brand</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($brands as $key => $brand_item)
          <tr>
            <td>{{ $brand_item->brand_id}}</td>
            <td>{{ $brand_item->brand_name}}</td>
            <td>{{ $brand_item->brand_description}}</span></td>
            <td>
              <?php
                if($brand_item->brand_status == 0) {
                ?>
                  <a href="{{URL::to('/admin/brand/public-brand/'.$brand_item->brand_id)}}"><span class="fa fa-times text-danger text"></span></a>
                <?php
                }
                else {
                  ?>
                  <a href="{{URL::to('/admin/brand/unpublic-brand/'.$brand_item->brand_id)}}"><span class="fa fa-check text-success text-active"></span></a>
                <?php
                }
              ?>
            </td>
            <td>
              <a href="{{URL::to('/admin/brand/edit/'.$brand_item->brand_id)}}" class="edit-brand" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-edit"></i>
              </a>
              <a a onclick="return confirm('Bạn có chắc chắn muốn xóa brand {{$brand_item->brand_name}}?')" href="{{URL::to('/admin/brand/delete/'.$brand_item->brand_id)}}" class="delete-brand" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      
      {{ $brands->links('admin.pagination') }}

    </footer>
  </div>
</div>
@endsection