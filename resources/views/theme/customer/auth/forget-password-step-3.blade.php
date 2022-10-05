@extends('theme.layout.index')

@section('seo')
<title>{{ 'Quên mật khẩu - Bước 3 | '.Helpers::get_option_minhnn('seo-title-add') }}</title>
<link rel="canonical" href="{{ url('/') }}" />
<meta name="robots" content="index, follow">
<meta name="description" content="{{ 'Quên mật khẩu - Bước 3  | '.Helpers::get_option_minhnn('seo-description-add') }}">
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
          <h2 class="text-center">@lang('Quên mật khẩu - Bước 3')</h2>
        </div>
         
         @if (count($errors) >0)
               @foreach($errors->all() as $error)
                 <div class="text-danger"> {{ $error }}</div>
               @endforeach
            @endif
            @if (session('status'))
               <div class="text-danger"> {{ session('status') }}</div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword_step3') }}">
               {{ csrf_field() }}
               <div class="input-group form-group mb-3">
                  <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required autofocus>
                  @if ($errors->has('new_password'))
                  <span class="help-block">
                  <strong>{{ $errors->first('new_password') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="input-group form-group mb-3">
                  <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới" name="confirm_new_password" required>
                  @if ($errors->has('confirm_new_password'))
                  <span class="help-block">
                  <strong>{{ $errors->first('confirm_new_password') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-login-page">@lang('Đổi mật khẩu')</button>
               </div>
            </form>

      </div>
    </div>
  </div>
</section>

@endsection