@extends('admin.layouts.app')
<?php
if(isset($post_variable)){
    $title = $post_variable->name;
    $post_title = $post_variable->name;
    $post_title_en = $post_variable->name_en;
    $post_slug = $post_variable->slug;
    $post_description = $post_variable->description;
    $post_description_en = $post_variable->description_en;
    $parent_id = $post_variable->parent;
    $status = $post_variable->status;
    
    $image = $post_variable->image;
    $cover = $post_variable->cover;
    $icon = $post_variable->icon;

    $date_update = $post_variable->updated_at;
    //khai báo biến SEO
    $seo_title = $post_variable->seo_title;
    $seo_keyword = $post_variable->seo_keyword;
    $seo_description = $post_variable->seo_description;
    $sid = $post_variable->id ;
    $type = $post_variable->type ;
    $stt = $post_variable->stt ;
} else{
    $title = 'Add new variable';
    $post_title = '';
    $post_title_en = '';
    $post_slug = '';
    $post_description = '';
    $post_description_en = '';
    $parent_id = 0;
    $status = 0;

    $image = '';
    $cover = '';
    $icon = '';

    $date_update = date('Y-m-d h:i:s');
    $seo_title = "";
    $seo_keyword = "";
    $seo_description = "";
    $sid = 0;
    $type = '';
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
        <form action="{{route('admin.postVariableProductDetail')}}" method="POST" id="frm-create-category" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{$sid}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4>{{$title}}</h4>
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
                                        <label for="post_title">Title</label>
                                        <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Title" value="{{$post_title}}">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="post_title_en">Title category</label>
                                        <input type="text" class="form-control" id="post_title_en" name="post_title_en" placeholder="Title" value="{{$post_title_en}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="template_checkID" class="title_txt">Parent variable</label>
                                <?php 
                                    $List_categories = App\Model\Variable::where('status', 0)->where('parent', 0)->get();
                                ?>
                                <select class="custom-select mr-2" name="category_parent">
                                    <option value="0" <?php if( $parent_id == 0): ?> selected <?php endif; ?> >== N/A ==</option>
                                    @if(count($List_categories)>0)
                                        @foreach ($List_categories as $Data_categories)
                                            @if( ((int)$Data_categories->id) > 0)
                                                <option value="<?php echo (int)$Data_categories->id; ?>" <?php if( $parent_id==(int)$Data_categories->id): ?> selected <?php endif; ?> >
                                                    <?php echo $Data_categories->name; ?>
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="template_checkID" class="title_txt">Kiểu nhập liệu</label>
                                <select name="type" class="custom-select mr-2">
                                    <option value="input" {{ $type=='input' ? 'selected' : '' }}>Input</option>
                                    <option value="checkbox" {{ $type=='checkbox' ? 'selected' : '' }}>Checkbox</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label for="template_checkID" class="title_txt">Priority</label>
                                <input type="text" class="form-control" name="stt" value="{{ $stt ?? 0 }}">
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button', compact('date_update'))
                    {{--@include('admin.partials.icon', ['title'=>'Icon', 'icon'=>$icon])--}}
                    @include('admin.partials.image', ['title'=>'Image', 'name'=>'image', 'icon'=>$image])
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

        
        //xử lý validate
        $("#frm-create-category").validate({
            rules: {
                post_title: "required",
            },
            messages: {
                post_title: "Nhập tiêu đề thể loại tin",
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