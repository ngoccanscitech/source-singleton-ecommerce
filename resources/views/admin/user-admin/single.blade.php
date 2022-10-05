@extends('admin.layouts.app')
<?php
$email = (isset($data_admin) && !empty($data_admin)) ? $data_admin->email : "";
$name = (isset($data_admin) && !empty($data_admin)) ? $data_admin->name : "";
$admin_level = (isset($data_admin) && !empty($data_admin)) ? $data_admin->admin_level : "";
$sid = (isset($data_admin) && !empty($data_admin)) ? $data_admin->id : 0;
$title = (isset($data_admin) && !empty($data_admin)) ? "Cập nhật quản trị viên" : "Thêm quản trị viên";
$status = (isset($data_admin) && !empty($data_admin)) ? $data_admin->status : 0;
$date_update = (isset($data_admin) && !empty($data_admin)) ? $data_admin->created : date('Y-m-d h:i:s');
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
        <form action="{{route('admin.addUserAdmin')}}" method="POST" id="frm-create-useradmin" enctype="multipart/form-data">
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
                                        <label for="post_title">Email</label>
                                        <input type="text" class="form-control title_slugify" id="post_title" name="email" placeholder="" value="{{$email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tên nhân viên</label>
                                        <input type="text" class="form-control slug_slugify" id="name" name="name" placeholder="" value="{{$name}}">
                                    </div>
                                    <!-- <label for="">Đổi mật khẩu?</label>
                                    <input data-videoType="" type="checkbox" name="" id="check_change_pass"> -->
                                    <div class="wrap-password">
                                        <div class="form-group">

                                            <label for="password">Mật khẩu</label>
                                            <input type="password" class="form-control slug_slugify" id="password" name="password" placeholder="" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="post_description">Xác nhận mật khẩu</label>
                                            <input type="password" class="form-control slug_slugify" id="repassword" name="repassword" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_description">Quyền</label>
                                        <select name="admin_level" id="admin_level" class="form-control">
                                            @if($admin_level==0 || $admin_level!=1)
                                            <option selected="" value="99999">Quản trị viên</option>
                                            {{-- <option value="1">Nhân viên</option> --}}
                                            @else
                                            <option value="99999">Quản trị viên</option>
                                            {{-- <option selected="" value="1">Nhân viên</option> --}}
                                            @endif
                                        </select>
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
                email: {
                  required: true,
                  // email: true
                },
                name: "required",
                password: "required",
                repassword: {
                    equalTo: "#password"
                },
            },
            messages: {
                email: {
                  required: "Vui lòng nhập Email",
                  // email: "Email không hợp lệ"
                },
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