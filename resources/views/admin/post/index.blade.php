@extends('admin.layouts.app')
@section('seo')
<?php

$data_seo = array(
    'title' => 'Tin tức | '.Helpers::get_option_minhnn('seo-title-add'),
);
$seo = WebService::getSEO($data_seo);
?>
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title_head }}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title">{{ $title_head }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('post')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createPost')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\Category::orderBy('name', 'ASC')->select('id', 'name')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category">
                                        <option value="">Thể loại tin tức</option>
                                        @foreach($list_cate as $cate)
                                            <option value="{{$cate->id}}" {{ request('category') == $cate->id ? 'selected' : ''  }}>{{$cate->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá" value="{{ request('search_title') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Thumbnail</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin.postDetail', array($data->id))}}">
                                                <b>{{$data->name}}</b>
                                                <br>
                                                <b style="color:#c76805;">{{$data->slug}}</b>                                
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if($data->category_post->count())
                                                @foreach($data->category_post as $category)
                                                    <a href="{{ route('admin.categoryPostDetail', $category->id) }}" target="_blank">{{ $category->name }}</a>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($data->image != '')
                                                <img src="{{asset($data->image)}}" style="height: 50px;">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                            <br>
                                            {{ $data->status == 0 ? 'Draft' : 'Public' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $posts->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection