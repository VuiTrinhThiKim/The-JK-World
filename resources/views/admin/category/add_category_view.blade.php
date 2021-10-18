@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục - category
            </header>
            <?php 
            $addCate_message = Session::get('messCate');
            if($addCate_message) {
                echo '<div class="text-danger">'.$addCate_message.'</div>';
                Session::put('messCate', null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/category/add')}}" role="form" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="categoryName">Tên danh mục<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" value="{{old('categoryName')}}" placeholder="Chân Váy JK">
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
                        <textarea style="resize: none;" rows=9 class="form-control" id="categoryDescription" name="categoryDescription" placeholder="Nhập thông tin">{{old('categoryDescription')}}</textarea> 
                        @if ($errors->has('categoryDescription'))
                            @error('categoryDescription')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                    	<label for="categoryStatus">Hiển thị danh mục lên website?<span class="required-field"> (*)</span></label>
                        <select class="form-control input-sm m-bot15" name="categoryStatus" required>
                            <option value="0" style="height: 150px; font-size: 14px;">Ẩn</option>
                            <option value="1" style="height: 150px; font-size: 14px;">Hiển thị</option>
                        </select>
                    </div>
                    <button type="submit" name="addCategory" class="btn btn-info">Thêm danh mục</button>
                	</form>
                </div>
            </div>
        </section>
	</div>
</div>
@endsection