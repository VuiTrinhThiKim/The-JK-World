@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Chỉnh sửa danh mục sản phẩm
            </header>
            <?php 
            $editBrand_message = Session::get('messBrand');
            if($editBrand_message) {
                echo '<div class="text-alert">'.$editBrand_message.'</div>';
                Session::put('messBrand', null);
            }
            ?>
            <div class="panel-body">
                @foreach($edit_brand as $key => $brand)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/admin/brand/update/'.$brand->brand_id)}}" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="brandName">Tên danh mục<span class="required-field"> (*)</span></label>
                        <input type="text" value="{{$brand->brand_name}}" class="form-control @error('brandName') is-invalid @enderror" id="brandName" name="brandName" placeholder="Chân Váy JK">
                        @if ($errors->has('brandName')) 
                            @error('brandName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="brandDescription">Thông tin brand<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=9 class="form-control @error('brandDescription') is-invalid @enderror" id="brandDescription" name="brandDescription" placeholder="Nhập thông tin">{{$brand->brand_description}}</textarea>
                        @if ($errors->has('brandDescription')) 
                            @error('brandDescription')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <button type="submit" name="updateBrand" class="btn btn-info">Cập nhật</button>
                	</form>
                </div>
                @endforeach
            </div>
        </section>
	</div>
</div>
@endsection