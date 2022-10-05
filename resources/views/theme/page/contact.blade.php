@php if($lc == 'vi'){ $lk = ''; } else { $lk = $lc; } @endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@endsection

@section('content')

<div id='contact-page'>
    <div id="contact-banner" class="banner">
        <div class="bg-fill">
            <div class="bg-img w-100">
                <img src="{{ url('assets/images/bg-contact.jpg') }}">
            </div>
            <div class="bg-overlay"></div>
        </div>
        <div class="banner-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 p-md-5 pt-3 bg-white contact-page-info">
                        {!! htmlspecialchars_decode(setting_option('contact-compay')) !!}
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2498.863056148403!2d4.413310615296614!3d51.221598339381075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c3f6ff8c85be5f%3A0xca419afaadc86feb!2sVan%20Boendalestraat%2013%2C%202000%20Antwerpen%2C%20B%E1%BB%89!5e0!3m2!1svi!2s!4v1644811511003!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <div class="col-lg-6 p-md-5 pt-3 bg-white contact-page-info">
                        <!-- <h3 class="fs-3 fw-bold">{{ __('Contact') }}</h3> -->
                        
                         <form method="POST" action="{{url('contact.html')}}" enctype="multipart/form-data">
                          @csrf
                          @include($templatePath .'.contact.contact_content')
                          <div class="text-center">
                                  <button type="submit" class="btn btn-primary">{{ __('Send message') }}</button>
                              </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection