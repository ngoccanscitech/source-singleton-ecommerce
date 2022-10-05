@extends('admin.layouts.app')
<?php
if(isset($post_detail)){
    $post_detail = $post_detail->toArray();
    extract($post_detail);
    
    $gallery = (isset($gallery) || $gallery != "") ? unserialize($gallery) : '';
    
    $date_update = $updated_at;

    $title_head = $title;
} else{
    $title_head = 'Dự án';
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
        <form action="{{route('admin.project.post')}}" method="POST" id="frm-create-post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? 0 }}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4>{{$title_head}}</h4>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="title" name="title" placeholder="Tiêu đề" value="{{ $title ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
                                    </div>
                                    @include('admin.partials.quote', ['description'=> $description ?? '' ])
                                    @include('admin.partials.content', ['content'=> $content ?? '' ])
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="price" class="title_txt">Giá</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="price" id="price" value="{{ isset($price) ? number_format($price) : 0 }}" aria-describedby="basic-addon2" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">/ m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="acreage" class="title_txt">Diện tích</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="acreage" id="acreage" value="{{ $acreage ?? 0 }}" aria-describedby="basic-addon2" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="apartment" class="title_txt">Căn hộ</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="apartment" id="apartment" value="{{ $apartment ?? 0 }}" aria-describedby="basic-addon2" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">căn</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="villa" class="title_txt">Biệt thự/nhà phố</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="villa" id="villa" value="{{ $villa ?? 0 }}" aria-describedby="basic-addon2" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">căn</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @php
                                        $province = \App\Model\Province::get();
                                    @endphp
                                    @include('admin.partials.select-label', [
                                        'label' => 'Chọn Tỉnh / Thành',
                                        'options' => $province,
                                        'name' => 'province_id',
                                        'class' => 'place_select',
                                        'type' => 'province',
                                        'child' => 'district',
                                        'item' => $province_id ?? '',
                                        'hasDefaultOption' => true,
                                    ])
                                </div>
                                <div class="form-group col-lg-6">
                                    @php
                                    if(isset($province_id) && $province_id!='')
                                        $district = \App\Model\District::where('province_id', $province_id)->get();
                                    @endphp
                                    @include('admin.partials.select-label', [
                                        'label' => 'Chọn Quận / Huyện',
                                        'options' => $district ?? '',
                                        'name' => 'district_id',
                                        'class' => 'place_select',
                                        'type' => 'district',
                                        'child' => 'ward',
                                        'item' => $district_id ?? '',
                                        'hasDefaultOption' => true,
                                    ])
                                </div>
                                <div class="form-group col-lg-6">
                                    @php
                                    if(isset($district_id) && $district_id!='')
                                        $ward = \App\Model\Ward::where('district_id', $district_id)->get();
                                    @endphp
                                    @include('admin.partials.select-label', [
                                        'label' => 'Chọn Phường / Xã',
                                        'options' => $ward ?? '',
                                        'name' => 'ward_id',
                                        'class' => 'place_select',
                                        'type' => 'ward',
                                        'child' => 'street',
                                        'item' => $ward_id ?? '',
                                        'hasDefaultOption' => true,
                                    ])
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="street" class="title_txt">Tên đường</label>
                                    <input type="text" name="street" id="street" value="{{$street ?? ''}}" class="form-control" placeholder="Nhập tên đường">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="title_txt">Địa chỉ</label>
                                <input type="text" name="address" id="address" value="{{$address ?? 0}}" class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @php
                                        $stage = \App\Model\Stage::get();
                                    @endphp
                                    @include('admin.partials.select-label', [
                                        'label' => 'Trạng thái',
                                        'options' => $stage ?? '',
                                        'name' => 'stage_id',
                                        'item' => $stage_id ?? '',
                                        'hasDefaultOption' => true,
                                    ])
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="form-group">
                                        <label for="stt" class="title_txt">Sắp xếp (Tăng dần)</label>
                                        <input type="text" name="stt" id="stt" value="{{$stt ?? 0}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    @php
                                        $investors = \App\Model\Investor::get();
                                    @endphp
                                    <label for="investor_id">Nhà đầu tư</label>
                                    <!--Or user form-control class in select-->
                                    <select class="form-control"name="investor_id" id="investor_id">
                                        <option value="">-- Chọn nhà đầu tư --</option>}
                                        @if($investors!='')
                                            @foreach($investors as $index => $option)
                                                <option value="{{ $option->id }}"
                                                    {{ isset($investor_id) && $investor_id == $option->id ? 'selected': '' }}>
                                                    {{ $option->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- variable -->
                            @php $variables = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->get(); @endphp
                            @include('admin.product.includes.variables', [
                                'data'=>$variables, 
                                'id_selected'=>$variables_selected ?? [], 
                                'variables_join' => $variables_join ?? ''
                            ])
                            <!-- variable -->

                            <!--Post Gallery-->
                            <div class="form-group">
                                @include('admin.partials.galleries', ['gallery_images'=> $gallery ?? '' ])
                            </div>
                            <!--End Post Gallery-->
                            <!--SEO-->
                            @include('admin.form-seo.seo')
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    
                    @php $categories = App\Model\CategoryProject::where('status', 0)->where('category_id', 0)->get(); @endphp
                    @include('admin.project.includes.categories', ['categories'=>$categories, 'id_selected'=>$category_selected])


                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img-cover', 'name'=>'cover', 'image'=>$cover??''])
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    editor('content');
    editorQuote('description');

    jQuery(document).ready(function ($){
        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        //xử lý validate
        $("#frm-create-post").validate({
            rules: {
                title: "required",
                'category[]': { required: true, minlength: 1 }
            },
            messages: {
                title: "Nhập tiêu đề tin",
                'category[]': "Chọn thể loại tin",
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