@extends('layout_view')

@section('content')
<section id="form" style="margin-top: 5%;"><!--form-->
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2><strong>Đăng nhập tài khoản</strong></h2>
					<?php 
		            $messCustomer = Session::get('messCustomer');
		            if($messCustomer) {
		                echo '<span class="text-alert">'.$messCustomer.'</span>';
		                Session::put('messCustomer', null);
		            }
		            ?>
					<form action="{{URL::to('/dang-nhap')}}" method="post">
						{{csrf_field()}}
						<label for="username">Tên đăng nhập<span class="required-field"> (*)</span></label>
						<input type="text" name="username" placeholder="Tên đăng nhập" />
						<label for="password">Mật khẩu<span class="required-field"> (*)</span></label>
						<input type="password" name="password" placeholder="Mật khẩu" />
						<span>
							<input type="checkbox" class="checkbox"> 
							Ghi nhớ đăng nhập
						</span>
						<button type="submit" class="btn btn-default">Đăng nhập</button>
					</form>
				</div><!--/login form-->
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4 col-sm-offset-1">
				<h2 class="or">HOẶC</h2>
			</div>
			<div class="col-sm-4">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-sm-offset-1">
				<div class="signup-form"><!--sign up form-->
					<h2><strong>Tạo tài khoản mới!</strong></h2>
					<form action="{{URL::to('/tao-tai-khoan')}}" method="post">
						{{ csrf_field() }}
						<input type="text" name="username" placeholder="Tên đăng nhập"/>
						<input type="text" name="lastName" placeholder="Họ"/>
						<input type="text" name="firstName" placeholder="Tên"/>
						<input type="number" name="customerPhone" placeholder="Số điện thoại"/>
						<input type="email" name="customerEmail" placeholder="Email"/>
						<input type="password" name="password" placeholder="Mật khẩu"/>
						<input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu"/>

						<button type="submit" class="btn btn-default">Đăng kí</button>
					</form>
				</div><!--/sign up form-->
			</div>
		</div>
	</div>
</section><!--/form-->
@endsection