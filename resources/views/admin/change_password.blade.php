@extends('admin_layout_view')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Đổi mật khẩu
            </header>
            <div class="panel-body">
                <div class="position-center" style="margin-top: 50px;">
                    <form action="{{URL::to('/admin/member/edit')}}" role="form" method="post">
                    {{csrf_field() }}
		                <div class="form-group">
		                    <label for="current_password">Mật khẩu hiện tại</label>
		                    <input type="password" class="form-control" id="current_password" name="current_password" value="">
		                </div>
		                <div class="form-group">
		                    <label for="password">Mật khẩu mới</label>
		                    <input type="text" class="form-control" id="password" name="password" value="">
		                </div>
		                <div class="form-group">
		                    <label for="password">Nhập lại mật khẩu mới</label>
		                    <input type="text" class="form-control" id="password" name="password" value="">
		                </div>
		                <div class="form-group">
		                    <button type="submit" name="editAdmin" class="btn btn-send" style="margin-left: 50%;">Cập nhật</button>
		                </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection