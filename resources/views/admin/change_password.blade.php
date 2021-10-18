@extends('admin_layout_view')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Đổi mật khẩu
            </header>

            <div class="panel-body">
                    	<?php 
        $status = Session::get('messUpdate');
        if($status) {
            echo '<div class="status_alert">'.$status.'</div>';
            Session::put('messUpdate', null);
        }
      ?>
                <div class="position-center" style="margin-top: 50px;">
                    <form action="{{URL::to('/admin/member/change-password/'.$admin_id)}}" role="form" method="post">
                    {{csrf_field() }}
		                <div class="form-group">
		                    <label for="current_password">Mật khẩu hiện tại</label>
		                    <input type="password" class="form-control" id="current_password" name="current_password">
		                </div>
		                <div class="form-group">
		                    <label for="password">Mật khẩu mới</label>
		                    <input type="password" class="form-control" id="password" name="password">
		                </div>
		                @if ($errors->has('password'))
                            @error('password')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                            @enderror
                        @endif
		                <div class="form-group">
		                    <label for="password_confirmation">Nhập lại mật khẩu mới</label>
		                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
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