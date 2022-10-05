@php
extract($data);
if($lc == 'en'){ $lk = ''; } else { $lk = $lc; }
@endphp

@extends('theme.layout.index')

@section('seo')
@include('theme.layout.seo')
@endsection

@section('content')
@push('head')
    <link href="{{ asset('theme/js/flexbin.css') }}" type="text/css" rel="stylesheet" media="all" />
@endpush

@include('theme.partials.banner', compact('page'))

    @php
        $categories = \App\Model\Category_Theme::where('status_category', 0)->orderby('categoryShort', 'asc')->get();
    @endphp
<div id='catalogue' class="container py-5">
    <div class="row g-2">
        <div class="col-lg-12">
            @if(count($categories)>0)
            <div class="flexbin flexbin-margin">
                @foreach($categories as $category)
                <a href="{{ route('product.category', $category->categorySlug) }}">
                    <img src="{{ asset($category->cover) }}">
                    <h3 class="cat-title">{{ $lc == 'en' ? $category->categoryName_en : $category->categoryName }}</h3>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        
    </div>
</div>
@endsection