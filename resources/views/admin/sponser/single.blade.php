@extends('admin.layouts.app')
<?php
if(isset($data_slider)){
    $title = $data_slider->name;
    $post_title = $data_slider->name;
    $link = $data_slider->link;
    $image = $data_slider->image;
    $cover = $data_slider->cover;
    $order = $data_slider->order;
    $status = $data_slider->status;
    $date_update = $data_slider->updated;
    $sid = $data_slider->id;
} else{
    $title = 'Create Sponser';
    $post_title = "";
    $link = '';
    $image = '';
    $cover = '';
    $order = 0;
    $status = 0;
    $date_update = date('Y-m-d h:i:s');
    $sid = 0;
}
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
        <form action="{{route('admin.postSponserDetail')}}" method="POST" id="frm-create-page" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{$sid}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">Post Page</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="form-group">
                                <label for="post_title">Tiêu đề</label>
                                <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Tiêu đề" value="{{$post_title}}">
                            </div>
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input id="link" type="text" name="link" class="form-control" value="{{$link}}">
                            </div>
                            <div class="form-group">
                                <label for="order">Order(Sắp xếp)</label>
                                <input id="order" type="text" name="order" class="form-control" value="{{$order}}">
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image])
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        $('#csv_slishow').change(function(evt) {
            $("#csv_upload_slishow").val($(this).val());
            $("#csv_upload_slishow").attr("value",$(this).val());
        });
        $('#csv_slishow_mobile').change(function(evt) {
           $("#csv_upload_slishow_mobile").val($(this).val());
           $("#csv_upload_slishow_mobile").attr("value",$(this).val());
        });
    });
</script>
@endsection