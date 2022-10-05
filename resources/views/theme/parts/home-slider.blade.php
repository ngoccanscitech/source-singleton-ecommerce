@php
    $sliders = \App\Model\Slider::where('status', 0)->where('slider_id', 42)->orderBy('order','asc')->get();
@endphp
@if($sliders->count())
<!--Home slider-->
{{--
    <div class="slideshow slideshow-wrapper">
    <div class="home-slideshow">
        @foreach($sliders as $slider)
        <div class="slide">
            <div class="blur-up lazyload">
                <img class="blur-up lazyload" data-src="{{ $slider->src }}" src="{{ $slider->src }}" alt="Summer Hot Collection" title="{{ $slider->name }}" />
                <div class="box-tit-banner">
                    {!! htmlspecialchars_decode($slider->description) !!}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

--}}
      <section class="tns-carousel tns-controls-lg">
        <div class="tns-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;nav&quot;:true, &quot;controls&quot;: false},&quot;992&quot;:{&quot;nav&quot;:false, &quot;controls&quot;: true}}}">
            @foreach($sliders as $slider)
            <!-- Item-->
            <div class="px-lg-5" style="background: url({{ $slider->src }});">
                <div class="d-lg-flex justify-content-between align-items-center ps-lg-4">
                    <div class="position-relative me-lg-n5 py-5 px-4 order-lg-1">
                        <div class="pb-lg-5 mb-lg-5 text-center text-lg-start text-lg-nowrap">
                            <h3 class="h2 pb-1 from-start text-">Tư vấn tận tâm</h3>
                            <h2 class=" display-5 from-top delay-1 text-">Giao thuốc nhanh chóng</h2>
                            
                            <div class="d-table scale-up delay-4 mx-auto"><a class="btn btn-primary" href="#">Mua thuốc ngay</a></div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
      </section>
<!--End Home slider-->
@endif