@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Chỉnh sửa danh mục sản phẩm
            </header>
            <?php 
            $addCate_message = Session::get('messCate');
            if($addCate_message) {
                echo '<span class="text-alert">'.$addCate_message.'</span>';
                Session::put('messCate', null);
            }
            ?>
            <div class="panel-body">
                @foreach($edit_category as $key => $edit_cate)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-category/'.$edit_cate->category_id)}}" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <label for="categoryName">Tên danh mục</label>
                        <input type="text" value="{{$edit_cate->category_name}}" class="form-control" id="categoryName" name="categoryName" placeholder="Chân Váy JK">
                    </div>
                    <div class="form-group">
                        <label for="categoryDescription">Thông tin danh mục</label>
                        <textarea style="resize: none;" rows=9 class="form-control" id="categoryDescription" name="categoryDescription" placeholder="Nhập thông tin">{{$edit_cate->description}}</textarea> 
                    </div>
                    <button type="submit" name="addCategory" class="btn btn-info">Cập nhật</button>
                	</form>
                </div>
                @endforeach
            </div>
        </section>
	</div>
</div>
@endsection