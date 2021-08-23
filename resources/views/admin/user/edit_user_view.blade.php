@extends('admin_layout_view')

@section('admin_content')
<div class="row">
	<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Chỉnh sửa thông tin người dùng
            </header>
            <?php 
            $addUser_message = Session::get('messUser');
            if($addUser_message) {
                echo '<span class="text-danger">'.$addUser_message.'</span>';
                Session::put('messUser', null);
            }
            ?>
            <div class="panel-body">
                @foreach($edit_user as $key => $edit_user)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/admin/user/update/'.$edit_user->user_id)}}" method="post" enctype="multipart/form-data">
                    {{csrf_field() }}
                    <div class="form-group">
                        <span class="required-field">Bắt buộc nhập các trường có dấu (*)</span>
                    </div>
                    <div class="form-group">
                        <label for="username">Tên đăng nhập<span class="required-field"> (*)</span></label>
                        <input type="text" class="form-control" id="username" name="username" value="{{$edit_user->username}}" placeholder="Nhập tên đăng nhập">
                        @if ($errors->has('username'))
                            @error('username')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userEmail">E-mail<span class="required-field"> (*)</span></label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" value="{{$edit_user->email}}"placeholder="example@gmail.com">
                        @if ($errors->has('userEmail'))
                            @error('userEmail')
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
                        <input type="text" class="form-control" id="firstName" name="firstName" value="{{$edit_user->first_name}}" placeholder="Nhập họ">
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
                        <input type="text" class="form-control" id="lastName" name="lastName"  value="{{$edit_user->last_name}}" placeholder="Nhập tên">
                        @if ($errors->has('lastName'))
                            @error('lastName')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userPhone">Số điện thoại<span class="required-field"> (*)</span></label>
                        <input type="number" class="form-control" id="userPhone" name="userPhone" value="{{$edit_user->phone}}" placeholder="0928090577">
                        @if ($errors->has('userPhone'))
                            @error('userPhone')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userAddress">Địa chỉ<span class="required-field"> (*)</span></label>
                        <textarea style="resize: none;" rows=4 class="form-control" id="userAddress" name="userAddress"placeholder="Nhập thông tin">{{$edit_user->address}}</textarea>
                        @if ($errors->has('userAddress'))
                            @error('userAddress')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userAvatar">Ảnh đại diện</label>
                        <input type="file" class="" id="userAvatar" name="userAvatar" onchange="imagesFileAsURL()">
                        @if ($errors->has('userAvatar'))
                            @error('userAvatar')
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

                            var fileSelected = document.getElementById('userAvatar').files;

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
                                @if($role->role_id == $edit_user->role_id)
                                <option selected value="{{$role->role_id}}" style="height: 150px; font-size: 14px;">{{$role->role_name}}</option>
                                @else
                                <option value="{{$role->role_id}}" style="height: 150px; font-size: 14px;">{{$role->role_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" name="updateUser" class="btn btn-info">Cập nhật</button>
                	</form>
                </div>
                @endforeach
            </div>
        </section>
	</div>
</div>
@endsection