@extends('admin_layout_view')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Lỗi
            </header>

            <div class="panel-body">
                    	
                <div class="position-center" style="margin-top: 50px; height: 400px;">
                    <?php 
				        $status = Session::get('messError');
				        if($status) {
				            echo '<div class="status_error">'.$status.'</div>';
				            Session::put('messError', null);
				        }
				      ?>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection