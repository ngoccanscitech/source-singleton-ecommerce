@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
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
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Product</li>
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
		            	<h3>Product</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createProduct')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\ShopCategory::where('parent', 0)->orderBy('id', 'ASC')
                                                ->select('id', 'name')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category_id">
                                        <option value="">Danh mục</option>
                                        @foreach($list_cate as $cate)
                                            <option value="{{$cate->id}}" {{ request('category_id') == $cate->id ? 'selected': '' }}>{{$cate->name}}</option>
                                            @if(count($cate->children)>0)
                                                @foreach($cate->children as $cate_child)
                                                    <option value="{{$cate_child->id}}" {{ request('category_id') == $cate_child->id ? 'selected': '' }}>   &ensp;&ensp;{{$cate_child->name}}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Tìm kiếm SP" value="{{ request('search_title') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fl" style="font-size: 17px;">
                                <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;">{{$total_item}}</span> sản phẩm
                            </div>
                            <div class="fr">
                                {!! $data_product->links() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" width="100" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Tên sản phẩm</th>
                                        <th scope="col" class="text-center">Danh mục</th>
                                        <th scope="col" class="text-center">Hình ảnh</th>
                                        <th scope="col" class="text-center">Ngày và trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_product as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td>
                                            <a class="row-title" href="{{route('admin.productDetail', array($data->id))}}">
                                                <b>{{$data->name}}</b>           
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                $categories = $data->categories;
                                                //dd($category);
                                            @endphp
                                            @foreach($categories as $k=>$category)
                                                {{ $k>0 ? ',':'' }} <a class="tag" target="_blank" href="#">{{ $category->name }}</a>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if($data->image != '')
                                                <img src="{{asset($data->image)}}" style="height: 50px;">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ date('d/m/Y', strtotime($data->expiry)) }}
                                            <br>
                                            @if($data->status == 1)
                                                <span class="badge badge-primary">Public</span>
                                            @else
                                                <span class="badge badge-secondary">Draft</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $data_product->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection