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
                echo '<div class="text-alert">'.$addCate_message.'</div>';
                Session::put('messCate', null);
            }
            ?>
            <div class="panel-body">
                @foreach($edit_category as $key => $edit_cate)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/admin/category/update/'.$edit_cate->category_id)}}" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="categoryName">Tên danh mục<span class="required-field"> (*)</span></label>
                        <input type="text" value="{{$edit_cate->category_name}}" class="form-control" id="categoryName" name="categoryName" placeholder="Chân Váy JK">
                        @if ($errors->has('categoryName'))
                            @error('categoryName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="categoryDescription">Thông tin danh mục<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=9 class="form-control" id="categoryDescription" name="categoryDescription" placeholder="Nhập thông tin">{{$edit_cate->category_description}}</textarea> 
                        @if ($errors->has('categoryDescription'))
                            @error('categoryDescription')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
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