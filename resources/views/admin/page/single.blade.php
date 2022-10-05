@extends('admin.layouts.app')
<?php
if(isset($page_detail)){
    $title = $page_detail->title;
    $post_title = $page_detail->title;
    $post_title_en = $page_detail->title_en;
    $post_slug = $page_detail->slug;
    $post_description = $page_detail->description;
    $post_description_en = $page_detail->description_en;
    $post_content = $page_detail->content;
    $post_content_en = $page_detail->content_en;
    $template = $page_detail->template;
    $show_footer = $page_detail->show_footer;
    $status = $page_detail->status;

    $image = $page_detail->image;
    $cover = $page_detail->cover;
    $icon = $page_detail->icon;

    $seo_title = $page_detail->seo_title;
    $seo_keyword = $page_detail->seo_keyword;
    $seo_description = $page_detail->seo_description;

    $date_update = $page_detail->updated;
    $sid = $page_detail->id;

    //link demo
    $link_url_check = route('page',array($page_detail->slug));
} else{
    $title = 'Create Page';
    $post_title = "";
    $post_title_en = "";
    $post_slug = "";
    $post_description = "";
    $post_description_en = "";
    $post_content = "";
    $post_content_en = "";
    $show_main_post = "";
    $avt_show_main_post = "";
    $template = '';
    $show_footer = 0;
    $status = 0;
    
    $image = '';
    $cover = '';
    $icon = '';

    $date_update = date('Y-m-d h:i:s');
    $sid = 0;
}
?>
@section('seo')
<?php
$data_seo = array(
    'title' => $title.' | '.Helpers::get_option_minhnn('seo-title-add')
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
        <form action="{{route('admin.postPageDetail')}}" method="POST" id="frm-create-page" enctype="multipart/form-data">
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
                            <ul class="nav nav-tabs hidden" id="tabLang" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="vi-tab" data-toggle="tab" href="#vi" role="tab" aria-controls="vi" aria-selected="true">Tiếng việt</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">Tiếng Anh</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="post_title">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Tiêu đề" value="{{$post_title}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="post_slug" name="post_slug" placeholder="Slug" value="{{$post_slug}}">
                                        <?php if($sid>0 && $template == 0): ?>
                                        <p><b style="color: #0000cc;">Demo Link:</b> <u><i><a  style="color: #F00;" href="<?php echo $link_url_check; ?>" target="_blank"><?php echo  $link_url_check; ?></a></i></u></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_description">Trích dẫn</label>
                                        <textarea id="post_description" name="post_description">{!!$post_description!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_content">Nội dung</label>
                                        <textarea id="post_content" name="post_content">{!!$post_content!!}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="post_title_en">Title</label>
                                        <input type="text" class="form-control" id="post_title_en" name="post_title_en" placeholder="Title" value="{{$post_title_en}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_description_en">Description</label>
                                        <textarea id="post_description_en" name="post_description_en">{!!$post_description_en!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_content_en">Content</label>
                                        <textarea id="post_content_en" name="post_content_en">{!!$post_content_en!!}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{--
                            <div class="form-group">
                                <label for="show_promotion" class="title_txt">Hiển thị template page trang chủ</label>
                                <input id="show_main_post" type="checkbox" value="1" name="show_main_post" <?php if($show_main_post == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                            </div>
                            <div class="form-group">
                                <label for="show_promotion" class="title_txt">Ảnh đại diện(template page trang chủ)</label>
                                <input id="avt_show_main_post" type="file" value="" name="avt_show_main_post" >
                                <input id="avt_show_main_post" type="hidden" value="{{$avt_show_main_post}}" name="avt_show_promotion_hidden">
                                @if($avt_show_main_post!="")
                                <div class="avt-promotion-img">
                                    <img src="{{asset('images/article/')}}/{{$avt_show_main_post}}">
                                </div>
                                @endif
                            </div>
                            --}}
                            <div class="form-group">
                                <label for="show_promotion" class="title_txt">Template</label>
                                <select name="template" class="form-control">
                                    <option value="page" {{ $template=='page' ? 'selected' : '' }}>Page</option>
                                    <option value="project" {{ $template=='project' ? 'selected' : '' }}>Dự án</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="template_checkID" style="color: #0C7FCC;" class="title_txt">Template Page (<i style="color: #0b2e13; font-size: 11px;">Lựa chọn sẽ không có link ra ngoài, sử dụng template html</i>)</label>
                                <input id="template_checkID" type="checkbox" name="template" value="1" @if($template == 1) checked @endif>
                            </div>
                            <div class="form-group">
                                <label for="show_footer" style="color: #FF0000;">Hiện thị Footer</label>
                                <input id="show_footer" type="checkbox" name="show_footer" value="1" @if($show_footer == 1) checked @endif>
                            </div> -->
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
                    @include('admin.form-seo.seo')
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image])
                    @include('admin.partials.image', ['title'=>'Hình ảnh Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=>$cover])
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });
        
        //xử lý validate
        $("#frm-create-page").validate({
            rules: {
                post_title: "required",
            },
            messages: {
                post_title: "Nhập tiêu đề trang",
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
<script type="text/javascript">
    editor('post_content');
    editor('post_content_en');
    editorQuote('post_description');
    editorQuote('post_description_en');
</script>
@endsection