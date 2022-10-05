@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'List User | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List User | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">List Users</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Users</li>
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
                        <h3 class="card-title">List Users</h3>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <div class="clear" style="margin-bottom: 10px">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" id="btn_deletes" onclick="delete_id('user_admin')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.postAddUserAdmin')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                        </div>
                  <table class="table table-bordered" id="table_index">
                    
                  </table>

                <script>
                $(function() {
                    let data2 ={!! $data_user !!};
                    $('#table_index').DataTable({
                        data: data2,
                        columns: [

                          {title: '<input type="checkbox" id="selectall" onclick="select_all()">', data: 'id'},
                          {title: 'Email/Tên đăng nhập', data: 'email'},
                          {title: 'Name', data: 'name'},
                          {title: 'Created', data: 'created_at'},
                          {title: 'Updated', data: 'updated_at'},
                        ],
                        order: [[ 3, "desc" ]],
                        columnDefs: [
                        {//ID
                            visible: true,
                            targets: 0,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return '<input type="checkbox" id="'+data+'" name="seq_list[]" value="'+data+'">';
                            }
                        },
                        {//date
                            visible: true,
                            targets: 1,
                            className: 'text-center a',
                            render: function (data, type, full, meta) {
                                return '<a href="{{route("admin.dashboard")}}/user-admin/' + full.id + '">'+data+'</a>';
                            }
                        },
                        {//name
                            visible: true,
                            targets: 2,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//name
                            visible: true,
                            targets: 3,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//name
                            visible: true,
                            targets: 4,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        }
                        
                    ],
                    });
                });
                </script>
                    </div> <!-- /.card-body -->
                </div><!-- /.card -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('#btn_deletes').click(function() {
        //     if(confirm('Bạn có chắc muốn xóa tài khoản?')){
        //         return true;
        //     }
        //     return false;
        // });
        
    });
</script>
@endsection
