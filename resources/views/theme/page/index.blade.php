@php extract($data); @endphp

@extends($templatePath.'.layouts.index')

@section('seo')
@endsection

@section('content')
    <div id='page-content'>
        <h1 class="text-center mt-3">{{ $page->title }}</h1>
        <div class="page-wrapper container my-5">
            <div class="row">
                <div class="col-12 mx-auto">
                    {!! htmlspecialchars_decode($page->content) !!}
                </div>
            </div>
        </div>
    </div>
@endsection