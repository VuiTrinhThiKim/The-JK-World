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
          <select class="input-sm form-control w-sm inline v-middle" name="filter">
            <option value="0">Xem tất cả</option>
            <option value="1">Sắp xếp giảm dần</option>
            <option value="2">Sắp xếp tăng dần</option>
            <option value="3">Xuất</option>
          </select>
          <button class="btn btn-sm btn-default" type="submit">Apply</button>
        </form>              
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <?php
          $keywords = Session::get('keywords');
        ?>
        <form action="{{URL::to('/admin/category/search')}}" method="get">
            {{csrf_field()}}
          <div class="input-group">
            <input type="text" name="keywords" value="{{$keywords}}" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="submit">Go!</button>
            </span>
          </div>
        </form>
      </div>
    </div>
    <div class="table-responsive">
      <?php 
        $statusCate_message = Session::get('messCate');
        if($statusCate_message) {
            echo '<span class="status_alert">'.$statusCate_message.'</span>';
            Session::put('messCate', null);
        }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th style="width:40%;">Tên danh mục</th>
            <th>Thông tin danh mục</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($result as $key => $cate_item)
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
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
              <a onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')" href="{{URL::to('/admin/category/delete/'.$cate_item->category_id)}}" class="delete-category" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection