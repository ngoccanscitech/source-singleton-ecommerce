@php
extract($data);
if($lc == 'en'){ $lk = ''; } else { $lk = $lc; };
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')

<!--=================================
breadcrumb -->
<div class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ url('/') }}"> <i class="fas fa-home"></i> </a></li>
          <li class="breadcrumb-item active"> <i class="fas fa-chevron-right"></i> <span> {{ $current->categoryName }} </span></li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!--=================================
breadcrumb -->

<!--=================================
Blog -->
<section class="space-ptb">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title">
          <h2>{{ $current->categoryName }}</h2>
        </div>
      </div>
    </div>

    <div class="row">
        @if(count($news)>0)
            @foreach($news as $post)
            <div class="col-lg-4 col-md-2 mb-4">
                @include('theme.news.includes.post-item', compact('post'))
            </div>
            @endforeach
        @endif
    </div>

</div>
</section>

@endsection