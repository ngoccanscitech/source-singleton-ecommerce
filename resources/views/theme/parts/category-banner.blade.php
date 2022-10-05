@php
$categories = Menu::getByName('Categories-Home') ;
@endphp
@if($categories)
<!--Small Banners-->
<div class="section imgBanners pt-4">
    <div class="imgBnrOuter">
        <div class="container-fluid">
            <div class="row">
                @if(isset($categories[0]))
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="inner">
                        <div class="inner btmleft">
                            <a href="{{ route('shop.detail', $categories[0]['link']) }}">
                                   <img class="blur-up lazyload" data-src="{{ asset($categories[0]['icon']) }}" src="{{ asset($categories[0]['icon']) }}" alt="{{ $categories[0]['label'] }}" title="{{ $categories[0]['label'] }}"/>
                                <div class="ttl"><small>Collection</small> <h4>{{ $categories[0]['label'] }}</h4></div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($categories[1]))
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="inner btmleft">
                        <a href="{{ route('shop.detail', $categories[1]['link']) }}">
                            <img class="blur-up lazyload" data-src="{{ asset($categories[1]['icon']) }}" src="{{ asset($categories[1]['icon']) }}" alt="{{ $categories[1]['label'] }}" title="{{ $categories[1]['label'] }}" />
                            <div class="ttl"><small>Collection</small> <h4>{{ $categories[1]['label'] }}</h4></div>
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                    @if(isset($categories[2]))
                    <div class="inner btmright mb-4">
                        <a href="{{ route('shop.detail', $categories[2]['link']) }}">
                            <img class="blur-up lazyload" data-src="{{ asset($categories[2]['icon']) }}" src="{{ asset($categories[2]['icon']) }}" alt="{{ $categories[2]['label'] }}" title="{{ $categories[2]['label'] }}" />
                            <div class="ttl"><small>Collection</small> <h4>{{ $categories[2]['label'] }}</h4></div>
                        </a>
                    </div>
                    @endif
                    @if(isset($categories[3]))
                    <div class="inner topleft">
                        <a href="{{ route('shop.detail', $categories[3]['link']) }}">
                            <img class="blur-up lazyload" data-src="{{ asset($categories[3]['icon']) }}" src="{{ asset($categories[3]['icon']) }}" alt="{{ $categories[3]['label'] }}" title="{{ $categories[3]['label'] }}" />
                            <div class="ttl"><small>Collection</small>  <h4>{{ $categories[3]['label'] }}</h4></div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Small Banners-->
@endif