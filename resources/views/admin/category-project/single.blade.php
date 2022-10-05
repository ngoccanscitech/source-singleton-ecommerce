@extends('admin.layouts.app')
<?php
if(isset($post_category)){
    $post_category = $post_category->toArray();
    extract($post_category);
    
    // $gallery = (isset($gallery) || $gallery != "") ? unserialize($gallery) : '';
    
    $date_update = $updated_at;

    $title_head = $title;
} else{
    $status = 0;
    $title_head = 'Danh mục dự án';
}
?>
@section('seo')
<?php
$data_seo = array(
    'title' => $title_head.' | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => $title_head.' | '.Helpers::get_option_minhnn('seo-title-add'),
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
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{$title_head}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{route('admin.project.category.post')}}" method="POST" id="frm-create-category" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? 0 }}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3>{{$title_head}}</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="title">Tên</label>
                                        <input type="text" class="form-control title_slugify" id="title" name="title" placeholder="Tiêu đề" value="{{ $title ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Đường dẫn thể loại tin</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
                                    </div>
                                    @include('admin.partials.quote', ['description'=> $description ?? '' ])
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template_checkID" class="title_txt">Chọn thể loại Cha</label>
                                <?php 
                                    $list_cate = App\Model\CategoryProject::where('category_id', 0)->get();
                                ?>
                                <select class="custom-select mr-2" name="category_id">
                                    <option value="0" >== Không có ==</option>
                                    @foreach($list_cate as $cate)
                                        <option value="{{$cate->id}}" {{ isset($category_id) && $category_id== $cate->id ? 'selected' : '' }} >{{$cate->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stt">Sắp xếp(Càng lớn càng nằm trên cùng)</label>
                                <input type="text" class="form-control" id="stt" name="stt" value="{{ $stt ?? 0 }}">
                            </div>
                            @include('admin.form-seo.seo')
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image ?? ''])
                    @include('admin.partials.image', ['title'=>'Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=>$cover ?? ''])
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    editorQuote('description');
    jQuery(document).ready(function ($){
        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        //xử lý validate
        $("#frm-create-category").validate({
            rules: {
                title: "required",
            },
            messages: {
                title: "Nhập tiêu đề thể loại tin",
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    });
</script>
@endsection