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
                echo '<span class="text-alert">'.$addProduct_message.'</span>';
                Session::put('messProduct', null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/product/save')}}" role="form" method="post"  enctype="multipart/form-data">
                    {{csrf_field() }}
                    <div class="form-group">
                        <label for="productName">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Chân Váy JK" required>
                    </div>
                    <div class="form-group">
                        <label for="brandName">Hình ảnh</label>
                        <input type="file" class="" id="productImage" name="productImage" onchange="imagesFileAsURL()" >
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
                                        newImage.class = "fileImage"
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
                        <label for="productPrice">Giá niêm yết</label>
                        <input type="text" class="form-control" id="productPrice" name="productPrice" placeholder="Chân Váy JK" required>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Mô tả sản phẩm</label>
                        <textarea style="resize: none;" rows=4 class="form-control" id="productDescription" name="productDescription" placeholder="Nhập thông tin" ></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="productContent">Chi tiết sản phẩm</label>
                        <textarea style="resize: none;" rows=9 class="form-control" id="brandDescription" name="productContent" placeholder="Nhập thông tin" required></textarea> 
                    </div>

                    <div class="form-group">
                        <label for="categoryID">Chọn danh mục</label>
                        <select class="form-control input-sm m-bot15" name="categoryID" >
                            @foreach($category_list as $key => $category)
                            <option value="{{$category->category_id}}" style="height: 150px; font-size: 14px;">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="brandID">Chọn brand</label>
                        <select class="form-control input-sm m-bot15" name="brandID" >
                            @foreach($brand_list as $key => $brand)
                            <option value="{{$brand->brand_id}}" style="height: 150px; font-size: 14px;">{{$brand->brand_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                    	<label for="productStatus">Hiển thị lên website</label>
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