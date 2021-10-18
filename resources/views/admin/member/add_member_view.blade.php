@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm quản trị viên - admin
            </header>
            <?php 
            $addMember_message = Session::get('messMember');
            if($addMember_message) {
                echo '<div class="text-danger">'.$addMember_message.'</div>';
                Session::put('messMember', null);
            }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form action="{{URL::to('/admin/member/add')}}" role="form" method="post"  enctype="multipart/form-data">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="username">Tên đăng nhập<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="username" name="username" value="{{old('username')}}" placeholder="Nhập tên đăng nhập">
                        @if ($errors->has('username'))
                            @error('username')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="adEmail">E-mail<span class="required-field"> (*)</span></label>
                        <input type="email" class="form-control" id="adEmail" name="adEmail" value="{{old('adEmail')}}"placeholder="example@gmail.com">
                        @if ($errors->has('adEmail'))
                            @error('adEmail')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu<span class="required-field"> (*)</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                        @if ($errors->has('password'))
                            @error('password')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Nhập lại mật khẩu<span class="required-field"> (*)</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập mật khẩu">
                        @if ($errors->has('password_confirmation'))
                            @error('password_confirmation')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="firstName">Tên<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="{{old('firstName')}}" placeholder="Nhập họ">
                        @if ($errors->has('firstName'))
                            @error('firstName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="lastName">Họ<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="lastName" name="lastName"  value="{{old('lastName')}}" placeholder="Nhập tên">
                        @if ($errors->has('lastName'))
                            @error('lastName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="adDOB">Ngày sinh</label>
                        <input type="date" class="form-control" id="adDOB" name="adDOB" value="{{old('adDOB')}}" >
                    </div>
                    <div class="form-group">
                        <label for="adGender">Giới tính</label>
                        <select type="date" class="form-control" id="adGender" name="adGender">
                            <option value="0" selected>Nam</option>
                            <option value="1">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="adPhone">Số điện thoại<span class="required-field"> (*)</span></label>
                        <input type="number" class="form-control" id="adPhone" name="adPhone" value="{{old('adPhone')}}" placeholder="0928090577">
                        @if ($errors->has('adPhone'))
                            @error('adPhone')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="adAddress">Địa chỉ<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=4 class="form-control" id="adAddress" name="adAddress" placeholder="Nhập thông tin" > {{old('adAddress')}}</textarea>
                        @if ($errors->has('adAddress'))
                            @error('adAddress')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="adAvatar">Ảnh đại diện</label>
                        <input type="file" class="" id="adAvatar" name="adAvatar" onchange="imagesFileAsURL()">
                        @if ($errors->has('adAvatar'))
                            @error('adAvatar')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group" id="showImage">
                    </div>
                    <script type="text/javascript">
                       
                        function imagesFileAsURL(){

                            var fileSelected = document.getElementById('adAvatar').files;

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
                        <label for="role_id">Chọn loại tài khoản<span class="required-field"> (*)</span></label>
                        <select class="form-control input-sm m-bot15" name="role_id" >
                            @foreach($role_list as $key => $role)
                            <option value="{{$role->role_id}}" style="height: 150px; font-size: 14px;">{{$role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" name="addAdmin" class="btn btn-info">Thêm quản trị viên</button>
                	</form>
                </div>
            </div>
        </section>
	</div>
</div>
@endsection