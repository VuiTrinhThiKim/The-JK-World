<!DOCTYPE html>
<head>
<title>Admin Panel | The JK World</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
</head>
<body>
<div class="reg-w3">
<div class="w3layouts-main">
	<h2>Thêm tài khoản</h2>
		<form action="{{URL::to('/admin/admin-dashboard')}}" method="post">
			<input type="text" class="ggg" name="adUsername" placeholder="Tên đăng nhập" required="">
			<input type="email" class="ggg" name="adEmail" placeholder="Địa chỉ email" required="">
			<input type="text" class="ggg" name="adPhone" placeholder="Số điện thoại" required="">
			<input type="text" class="ggg" name="adFirstName" placeholder="Họ" required="">
			<input type="text" class="ggg" name="adLastName" placeholder="Tên" required="">
			<input type="text" class="ggg" name="adAddress" placeholder="Địa chỉ" required="">
			<input type="password" class="ggg" name="password" placeholder="PASSWORD" required="">
			<input type="password" class="ggg" name="password_confirmation" placeholder="PASSWORD" required="">
			<label class="admin_role" for="roleId">Loại tài khoản</label>
            <select class="role_item" name="roleId" required>
                <option value="1" class="option_item">Manager</option>
                <option value="1" class="option_item">Staff</option>
            </select>
			<div class="clearfix"></div>
			<input type="submit" value="submit" name="register">
		</form>
</div>
</div>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
</body>
</html>
