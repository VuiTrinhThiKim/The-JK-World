@extends('admin_layout_view')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thông tin tài khoản
            </header>
            <div class="panel-body">
                @foreach($admin as $key => $admin)
                <div class="position-content">
                    <form action="{{URL::to('/admin/member/edit')}}" role="form" method="post">
                    {{csrf_field() }}
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <img src="{{asset('upload/avatar/admin/'.$admin->avatar)}}" alt="admin_avatar" width="250" height="250">
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="admin_id">Mã admin</label>
                                <input type="text" class="form-control" id="admin_id" name="admin_id" value="{{$admin->admin_id}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="admin_id">Loại tài khoản</label>
                                <input type="text" class="form-control" id="admin_id" name="admin_id" value="{{$admin_role}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{$admin->username}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="firstName">Tên</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$admin->first_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="lastName">Họ</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{$admin->last_name}}" >
                            </div>
                            <div class="form-group">
                                <label for="adDOB">Ngày sinh</label>
                                <input type="date" class="form-control" id="adDOB" name="adDOB" value="{{$admin->dob}}" >
                            </div>
                            <div class="form-group">
                                <label for="adGender">Giới tính</label>
                                <select type="date" class="form-control" id="adGender" name="adGender">
                                    @if($admin->gender == 0)
                                    <option value="0" selected>Nam</option>
                                    <option value="1">Nữ</option>
                                    @else
                                    <option value="0">Nam</option>
                                    <option value="1" selected>Nữ</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="adEmail">Email</label>
                                <input type="text" class="form-control" id="adEmail" name="adEmail" value="{{$admin->email}}">
                            </div>
                            <div class="form-group">
                                <label for="adPhone">Số điện thoại</label>
                                <input type="text" class="form-control" id="adPhone" name="adPhone" value="{{$admin->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="adPhone">Địa chỉ</label>
                                <textarea style="resize: none;" rows=4 class="form-control" id="adAddress" name="adAddress"placeholder="Nhập thông tin" >{{$admin->address}}</textarea>
                            </div>
                            <div class="form-group update-avt">
                                <label for="avatar">Đổi ảnh đại diện</label>
                                <input type="file" name="avatar">
                                
                            </div>
                            <div class="form-group">
                                <button type="submit" name="editAdmin" class="btn btn-send">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>
@endsection