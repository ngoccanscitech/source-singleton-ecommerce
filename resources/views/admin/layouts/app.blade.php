<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('seo')
  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" id="fontawesome-css" href="https://use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1" type="text/css" media="all">
  <!-- Admin Css -->
  <link rel="stylesheet" href="{{url('assets/css/admin-expro.min.css')}}">
  <!-- Admin Custom Css -->
  <link rel="stylesheet" href="{{url('assets/css/style_admin.css?ver=1')}}">
  <!-- Admin js -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="{{ asset('assets/js/admin.expro.js') }}"></script>
  <script src="{{ asset('assets/js/js_admin.js?ver=1.1') }}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
  <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>

  @yield('style')
  @stack('styles')
</head>

@include('admin.layouts.header')
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('index')}}" class="nav-link">Home</a>
          </li>
        </ul>

    </nav>
    <!-- /.navbar -->
    @include('admin.layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
        @yield('contents')
    </div> <!-- /.content-wrapper -->
@include('admin.layouts.footer')
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
  jQuery(document).ready(function ($){
    //Date range picker
    $('#cus_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#cus_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    
  });
</script>
@yield('scripts')
@stack('scripts')
@stack('scripts-footer')
</body>
</html>