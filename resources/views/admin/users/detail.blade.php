@extends('admin.layouts.app')
@section('seo')
<?php
$title = "Thông tin thành viên";
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
        <form action="" method="" id="" >
            @csrf
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
                                        <input disabled="" type="text" class="form-control title_slugify" placeholder="" value="{{$user->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Họ và tên</label>
                                        <input disabled="" type="text" class="form-control slug_slugify" placeholder="" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Số điện thoại</label>
                                        <input disabled="" type="text" class="form-control slug_slugify"  placeholder="" value="{{$user->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Địa chỉ</label>
                                        <input disabled="" type="text" class="form-control slug_slugify" placeholder="" value="{{$user->address}}">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Tỉnh/thành phố</label>
                                                    <input disabled="" type="text" class="form-control slug_slugify"placeholder="" value="{{$user->province}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Quận/huyện</label>
                                                    <input disabled="" type="text" class="form-control slug_slugify" placeholder="" value="{{$user->district}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Phường/xã</label>
                                                    <input disabled="" type="text" class="form-control slug_slugify" placeholder="" value="{{$user->ward}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Mô tả</label>
                                        <textarea disabled="" cols="30" rows="4" class="form-control">{{$user->about_me}}</textarea>
                                    </div>
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <!-- /.col-9 -->    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
@endsection