<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- <title>{{ setting_option('company_name') }}</title> -->
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />

    <!-- SEO meta -->
    @yield('seo')

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gideon+Roman&display=swap" rel="stylesheet">
    <link rel='stylesheet' id='fontawesome-css' href='//use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1' type='text/css' media='all' />
    <!-- Plugins CSS -->
    <!-- <link rel="stylesheet" href="{{ url($templateFile .'/css/plugins.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset($templateFile .'/plugins/owl-carousel/assets/owl.carousel.min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset($templateFile .'/plugins/owl-carousel/assets/owl.theme.default.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset($templateFile .'/plugins/fancybox/fancybox.css') }}">
    <!-- Bootstap CSS -->
    <!-- <link rel="stylesheet" href="{{ url($templateFile .'/css/bootstrap.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset($templateFile .'/js/vendor/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset($templateFile .'/js/vendor/owl-carousel/assets/owl.theme.default.min.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ url($templateFile .'/css/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ url($templateFile .'/css/tiny-slider.css') }}">
    <link rel="stylesheet" href="{{ url($templateFile .'/css/drift-basic.min.css') }}">

    <link rel="stylesheet" href="{{ url($templateFile .'/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ url($templateFile .'/css/style.css?ver='. time()) }}">
    <!-- <link rel="stylesheet" href="{{ url($templateFile .'/css/responsive.css') }}"> -->
    <link rel="stylesheet" href="{{ url($templateFile .'/css/customer.css') }}">
    
    {!! htmlspecialchars_decode(setting_option('header')) !!}
    
    @stack('head-style')

    @stack('head-script')
</head>

<body>
    <main class="page-wrapper">

    </main>

        @php $headerMenu = Menu::getByName('Menu-main'); @endphp
        
        @include($templateFile .'.layouts.header')

        {{--@include($templateFile .'.layouts.mobile-menu')--}}

        @yield('content')

        @include($templateFile .'.layouts.footer')

        <!-- Including Jquery -->
        <script src="{{ asset($templateFile .'/js/jquery.min.js') }} "></script>
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="{{ asset($templateFile .'/js/simplebar.min.js') }} "></script>
        <script src="{{ asset($templateFile .'/js/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset($templateFile .'/js/bootstrap.bundle.min.js') }} "></script>
        <script src="{{ asset($templateFile .'/js/tiny-slider.js') }} "></script>
        <script src="{{ asset($templateFile .'/js/smooth-scroll.polyfills.min.js') }} "></script>
        <script src="{{ asset($templateFile .'/js/Drift.min.js') }} "></script>
        <script src="{{ asset($templateFile .'/js/theme.min.js') }}"></script>

        <script src="{{ asset($templateFile .'/js/custom.js?ver=1.62') }}"></script>

        @stack('after-footer')
</body>

</html>
