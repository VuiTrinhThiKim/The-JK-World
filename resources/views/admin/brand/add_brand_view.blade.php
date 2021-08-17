@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thương hiệu - brand
            </header>
            <?php 
            $addBrand_message = Session::get('messBrand');
            if($addBrand_message) {
                echo '<span class="text-alert">'.$addBrand_message.'</span>';
                Session::put('messBrand', null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/brand/save')}}" role="form" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <label for="brandName">Tên thương hiệu</label>
                        <input type="text" class="form-control" id="brandName" name="brandName" placeholder="Chân Váy JK" required>
                    </div>
                    <div class="form-group">
                        <label for="brandDescription">Thông tin thương hiệu</label>
                        <textarea style="resize: none;" rows=9 class="form-control" id="brandDescription" name="brandDescription" placeholder="Nhập thông tin" required></textarea> 
                    </div>
                    <div class="form-group">
                    	<label for="brandStatus">Hiển thị lên website</label>
                        <select class="form-control input-sm m-bot15" name="brandStatus" required>
                            <option value="0" style="height: 150px; font-size: 14px;">Ẩn</option>
                            <option value="1" style="height: 150px; font-size: 14px;">Hiển thị</option>
                        </select>
                    </div>
                    <button type="submit" name="addBrand" class="btn btn-info">Thêm brand</button>
                	</form>
                </div>
            </div>
        </section>
	</div>
</div>
@endsection