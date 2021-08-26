@extends('layout_view')

@section('content')
<div id="contact-page" class="container" style="width:100%;">
	<div class="bg">
    	<div class="row">    		
    		<div class="col-sm-12">    			   			
				<h2 class="title text-center">Liên Hệ Với <strong>Chúng Tôi</strong></h2>    			    				    				
				<div id="gmap" class="contact-map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.9352036098144!2d106.67562381428733!3d10.81627076141587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e195f816b7%3A0xfb5c0101490d8870!2zMzcxIE5ndXnhu4VuIEtp4buHbSwgUGjGsOG7nW5nIDMsIEfDsiBW4bqlcCwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1629956202212!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>			 		
		</div>    	
		<div class="row" style="margin-top: 5%;">  	
    		<div class="col-sm-6">
    			<div class="contact-form">
    				<h2 class="title text-center">Góp ý cho chúng tôi</h2>
    				<div class="status alert alert-success" style="display: none"></div>
			    	<form id="main-contact-form" class="contact-form row" name="contact-form" method="post">
			            <div class="form-group col-md-6">
			                <input type="text" name="name" class="form-control" required="required" placeholder="Họ tên">
			            </div>
			            <div class="form-group col-md-6">
			                <input type="email" name="email" class="form-control" required="required" placeholder="Email">
			            </div>
			            <div class="form-group col-md-12">
			                <input type="text" name="subject" class="form-control" required="required" placeholder="Tiêu đề">
			            </div>
			            <div class="form-group col-md-12">
			                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Nội dung tin nhắn"></textarea>
			            </div>                        
			            <div class="form-group col-md-12">
			                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi">
			            </div>
			        </form>
    			</div>
    		</div>
    		<div class="col-sm-6">
    			<div class="contact-info">
    				<h2 class="title text-center">Thông tin liên hệ</h2>
    				<address>
    					<h2>The<span style="color: #EF6C7D;"> JK </span> World</h2>
    					<p><strong>Thứ 2 - Chủ Nhật: </strong> 9h - 21h</p>
						<p><strong>Địa chỉ: </strong>371 Nguyễn Kiệm, phường 3, quận Gò Vấp, TP.HCM</p>
						<p><strong>Điện thoại:</strong> 0928090577</p>
						<p><strong>Email:</strong> 1851010157vui@ou.edu.vn</p>
    				</address>
    				<div class="social-networks">
    					<h2 class="title text-center">Mạng xã hội</h2>
						<ul>
							<li>
								<a href="{{('https://www.facebook.com/im.dzui')}}"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-google-plus"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-youtube"></i></a>
							</li>
						</ul>
    				</div>
    			</div>
			</div>    			
    	</div>  
	</div>	
</div><!--/#contact-page-->
@endsection