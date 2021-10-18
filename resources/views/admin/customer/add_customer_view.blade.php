@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thương hiệu - brand
            </header>
            <?php 
            $add_message = Session::get('mess');
            if($add_message) {
                echo '<div class="text-alert">'.$add_message.'</div>';
                Session::put('mess', null);
            }
            ?>
            
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/brand/add')}}" role="form" method="post">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="brandName">Tên thương hiệu<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control @error('brandName') is-invalid @enderror" value="{{old('brandName')}}" id="brandName" name="brandName" placeholder="Đông Lâm Xã">
                        @if ($errors->has('brandName'))
                            @error('brandName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="brandDescription">Thông tin thương hiệu<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=9 class="form-control @error('brand_description') is-invalid @enderror" id="brandDescription" name="brandDescription" placeholder="Nhập thông tin">{{ old('brandDescription')}}</textarea>
                        @if ($errors->has('brandDescription')) 
                            @error('brandDescription')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                    	<label for="brandStatus">Hiển thị lên website?<span class="required-field"> (*)</span></label>
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