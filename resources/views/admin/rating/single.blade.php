@extends('admin.layouts.app')
<?php
// $name = (isset($data_admin) && !empty($data_admin)) ? $data_admin->email : "";
// $name = (isset($data_admin) && !empty($data_admin)) ? $data_admin->name : "";
// $admin_level = (isset($data_admin) && !empty($data_admin)) ? $data_admin->admin_level : "";
// $sid = (isset($data_admin) && !empty($data_admin)) ? $data_admin->id : 0;
// $title = (isset($data_admin) && !empty($data_admin)) ? "Detail Ratings" : "Detail Ratings";
// $status = (isset($data_admin) && !empty($data_admin)) ? $data_admin->status : 1;
// $date_update = (isset($data_admin) && !empty($data_admin)) ? $data_admin->created : date('Y-m-d h:i:s');



// $name = (isset($rating) && !empty($rating)) ? $rating->rating : "";
// $rating = (isset($rating) && !empty($rating)) ? $rating->rating : "";
// echo $rating_content = (isset($rating) && !empty($rating)) ? $rating->rating_content : "";
// $sid = (isset($rating) && !empty($rating)) ? $rating->id : 0;
// $title = (isset($rating) && !empty($rating)) ? "Detail Ratings" : "Detail Ratings";
// $status = (isset($rating) && !empty($rating)) ? $rating->status : 1;
// $date_update = (isset($rating) && !empty($rating)) ? $rating->created : date('Y-m-d h:i:s');
// $link_product = (isset($rating) && !empty($rating)) ? $rating->link_product: "";
$title = "Detail Ratings";
$sid = (isset($rating) && !empty($rating)) ? $rating->id : 0;
$date_update = (isset($rating) && !empty($rating)) ? $rating->created_at : date('Y-m-d h:i:s');

// echo '<pre>';
// print_r($rating->toArray());
// echo '</pre>';die();
?>
@section('seo')
<?php
$data_seo = array(
    'title' => $title.' | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => $title.' | '.Helpers::get_option_minhnn('seo-title-add'),
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{$title}}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{route('admin.postRating')}}" method="POST" id="frm-create-useradmin" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{$sid}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">{{$title}}</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="post_title">Khách hàng</label>
                                        <input type="text" class="form-control title_slugify" disabled="" placeholder="" value="{{$rating->user->name}}">
                                        <input type="hidden" name="id_rating" value="{{$rating->id}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Đánh giá</label> <br>
                                        {{$rating->rating}} <i style="color: #f7b003" class="fas fa-star"></i>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nội dung</label>
                                        <input type="text" class="form-control slug_slugify" disabled="" placeholder="" value="{{$rating->rating_content}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Link sản phẩm</label> <br>
                                        <a href="{{$rating->link_product}}">{{$rating->link_product}}</a>
                                    </div>
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publish</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <?php $status = $rating->status; ?>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioDraft" name="status" value="1" @if($status == 1) {{"checked"}} @endif>
                                    <label for="radioDraft">Draft</label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left: 15px;">
                                    <input type="radio" id="radioPublic" name="status" value="0" @if($status == 0) {{"checked"}} @endif>
                                    <label for="radioPublic">Public</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="created" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_update}}">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
               </div> <!-- /.col-9 -->    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        //xử lý validate
        $("#frm-create-useradmin").validate({
            rules: {
                email: "required",
                name: "required",
                password: "required",
                repassword: {
                    equalTo: "#password"
                },
            },
            messages: {
                email: "Nhập email/tên đăng nhập",
                name: "Nhập tên nhân viên",
                password: "Nhập mật khẩu",
                repassword: "Mật khẩu không chính xác",
            },

            // errorElement : 'div',
            // errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });

        //check change pass
        // $('#check_change_pass').click(function() {
        //     $('.wrap-password').css();
        // });
    });
</script>
<script type="text/javascript">
	CKEDITOR.replace('post_content',{
		width: '100%',
		resize_maxWidth: '100%',
		resize_minWidth: '100%',
		height:'300',
		filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',
	});
	CKEDITOR.instances['post_content'];

    CKEDITOR.replace('post_content_en',{
        width: '100%',
        resize_maxWidth: '100%',
        resize_minWidth: '100%',
        height:'300',
        filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',
    });
    CKEDITOR.instances['post_content_en'];
</script>
@endsection
@section('style')
<style>
    #frm-create-useradmin .error{
        color:#dc3545;
        font-size: 13px;
    }
</style>
@endsection