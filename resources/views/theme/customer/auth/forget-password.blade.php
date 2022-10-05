@extends($templatePath .'.layouts.index')

@section('body_class', 'user-page')

@section('content')
<div id="page-content" class="page-template">
  <!--Page Title-->
  <div class="page section-header text-center">
      <div class="page-title">
          <div class="wrapper"><h1 class="page-width">@lang('Forget password')</h1></div>
        </div>
  </div>
  <!--End Page Title-->

  <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 main-col">
            @if (count($errors) >0)
               @foreach($errors->all() as $error)
                 <div class="text-danger"> {{ $error }}</div>
               @endforeach
            @endif
            @if (session('status'))
               <div class="text-danger"> {{ session('status') }}</div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword') }}">
               {{ csrf_field() }}
               <div class="input-group form-group mb-3">
                  <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-login-page">@lang('Tiếp tục')</button>
               </div>
            </form>
        </div>
      </div>
    </div>
</div>


@endsection