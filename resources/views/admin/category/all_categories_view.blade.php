@extends('admin_layout_view')

@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách danh mục sản phẩm
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <form action="{{URL::to('/admin/category/filter')}}">
          {{csrf_field()}}
           <!-- <label for="filter">Lọc dữ liệu</label> -->
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
        <form action="{{URL::to('/admin/category/search')}}" method="get">
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
        $statusCate_message = Session::get('messCate');
        if($statusCate_message) {
            echo '<div class="status_alert">'.$statusCate_message.'</div>';
            Session::put('messCate', null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:5%;">ID</th>
            <th style="width:30%;">Tên danh mục</th>
            <th>Thông tin danh mục</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $key => $cate_item)
          <tr>
            <td>{{ $cate_item->category_id}}</td>
            <td>{{ $cate_item->category_name}}</td>
            <td>{{ $cate_item->category_description}}</span></td>
            <td>
              <?php
                if($cate_item->category_status == 0) {
                ?>
                  <a href="{{URL::to('/admin/category/public-category/'.$cate_item->category_id)}}"><span class="fa fa-times text-danger text"></span></a>
                <?php
                }
                else {
                  ?>
                  <a href="{{URL::to('/admin/category/unpublic-category/'.$cate_item->category_id)}}"><span class="fa fa-check text-success text-active"></span></a>
                <?php
                }
              ?>
            </td>
            <td>
              <a href="{{URL::to('/admin/category/edit/'.$cate_item->category_id)}}" class="edit-category" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-edit"></i>
              </a>
              <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục {{ $cate_item->category_name}}?')" href="{{URL::to('/admin/category/delete/'.$cate_item->category_id)}}" class="delete-category" ui-toggle-class="">
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
      {{ $categories->links('admin.pagination') }}
    </footer>
  </div>
</div>
@endsection
