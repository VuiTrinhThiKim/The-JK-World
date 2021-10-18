@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm - product
            </header>
            <?php 
            $addProduct_message = Session::get('messProduct');
            if($addProduct_message) {
                echo '<div class="text-alert">'.$addProduct_message.'</div>';
                Session::put('messProduct', null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/product/add')}}" role="form" method="post"  enctype="multipart/form-data">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="productName">Tên sản phẩm<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="productName" name="productName" value="{{old('productName')}}" placeholder="Chân Váy JK">
                        @if ($errors->has('productName'))
                            @error('productName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="productImage">Hình ảnh</label>
                        <input type="file" class="" id="productImage" name="productImage" onchange="imagesFileAsURL()">
                    </div>
                    <div class="form-group" id="showImage">
                    </div>
                    <script type="text/javascript">
                       
                        function imagesFileAsURL(){

                            var fileSelected = document.getElementById('productImage').files;

                            if(fileSelected.length > 0){

                                for(var i = 0; i < fileSelected.length; i++){
                                    var fileToLoad = fileSelected[i];

                                    var fileReader = new FileReader();
                                    fileReader.onload = function(fileLoaderEvent){

                                        var srcImage = fileLoaderEvent.target.result;

                                        var newImage = document.createElement('img');
                                        newImage.src = srcImage;
                                        newImage.className = "preview-image";
                                        newImage.style.height = "200px";
                                        newImage.style.width = "200px";

                                        document.getElementById('showImage').innerHTML += newImage.outerHTML;
                                    }

                                    fileReader.readAsDataURL(fileToLoad);
                                }
                            }
                        }
                    </script>
                    <div class="form-group">
                        <label for="productQty">Số lượng<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="productQty" name="productQty" value="{{old('productQty')}}" placeholder="Chân Váy JK">
                        @if ($errors->has('productQty'))
                            @error('productQty')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Giá niêm yết<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="productPrice" name="productPrice" value="{{old('productPrice')}}" placeholder="Chân Váy JK">
                        @if ($errors->has('productPrice'))
                            @error('productPrice')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="productWeight">Cân nặng - kg<span class="required-field"> (*)</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="productWeight" name="productWeight" value="{{old('productWeight')}}" placeholder="Chân Váy JK">
                        @if ($errors->has('productWeight'))
                            @error('productWeight')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Mô tả sản phẩm<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=4 class="form-control" id="productDescription" name="productDescription" placeholder="Nhập thông tin" >{{old('productDescription')}}</textarea>
                        @if ($errors->has('productDescription'))
                            @error('productDescription')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="productContent">Chi tiết sản phẩm<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=9 class="form-control" id="productContent" name="productContent" value="{{old('productContent')}}" placeholder="Nhập thông tin"></textarea>
                        @if ($errors->has('productContent'))
                            @error('productContent')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="categoryID">Chọn danh mục<span class="required-field"> (*)</span></label>
                        <select class="form-control input-sm m-bot15" name="categoryID" >
                            @foreach($category_list as $key => $category)
                            <option value="{{$category->category_id}}" style="height: 150px; font-size: 14px;">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="brandID">Chọn brand<span class="required-field"> (*)</span></label>
                        <select class="form-control input-sm m-bot15" name="brandID" >
                            @foreach($brand_list as $key => $brand)
                            <option value="{{$brand->brand_id}}" style="height: 150px; font-size: 14px;">{{$brand->brand_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                    	<label for="productStatus">Hiển thị lên website?<span class="required-field"> (*)</span></label>
                        <select class="form-control input-sm m-bot15" name="productStatus">
                            <option value="0" style="height: 150px; font-size: 14px;">Ẩn</option>
                            <option value="1" style="height: 150px; font-size: 14px;">Hiển thị</option>
                        </select>
                    </div>
                    <button type="submit" name="addProduct" class="btn btn-info">Thêm sản phẩm</button>
                	</form>
                </div>
            </div>
        </section>
	</div>
</div>
@endsection