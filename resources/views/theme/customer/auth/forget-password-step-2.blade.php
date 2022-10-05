@extends('theme.layout.index')

@section('seo')
<title>{{ 'Quên mật khẩu - Bước 2 | '.Helpers::get_option_minhnn('seo-title-add') }}</title>
<link rel="canonical" href="{{ url('/') }}" />
<meta name="robots" content="index, follow">
<meta name="description" content="{{ 'Quên mật khẩu - Bước 2  | '.Helpers::get_option_minhnn('seo-description-add') }}">
<meta property="og:title" content="{{ Helpers::get_option_minhnn('og-title') }}" />
<meta property="og:description" content="{{ Helpers::get_option_minhnn('og-description') }}" />
<meta property="og:image" content="{{ url(Helpers::get_option_minhnn('og-image')) }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ Helpers::get_option_minhnn('og-site-name') }}" />
@endsection
@section('body_class', 'user-page')
@section('content')
<section class="space-ptb login">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-sm-10">
        <div class="section-title">
          <h2 class="text-center">@lang('Quên mật khẩu - Bước 2')</h2>
        </div>
         
         @if (count($errors) >0)
               @foreach($errors->all() as $error)
                 <div class="text-danger"> {{ $error }}</div>
               @endforeach
            @endif
            @if (session('status'))
               <div class="text-danger"> {{ session('status') }}</div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword_step2') }}">
               {{ csrf_field() }}
               <div class="input-group form-group mb-3">
                  <input type="text" name="otp_mail" placeholder="OTP in email" class="txt_id form-control" required autofocus>
                  @if ($errors->has('otp_mail'))
                  <span class="help-block">
                  <strong>{{ $errors->first('otp_mail') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-login-page">@lang('Tiếp tục')</button>
               </div>
            </form>


      </div>
    </div>
  </div>
</section>

@endsection