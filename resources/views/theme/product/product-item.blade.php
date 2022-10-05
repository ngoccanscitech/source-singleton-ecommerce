@php
$sale = 0;
if($product->promotion){
    $sale = round(100 - ($product->promotion * 100 / $product->price));
}
@endphp
<!-- Product-->
<div>
    <div class="card product-card card-static pb-2">
        @if($sale)
        <div class="product-sale">Sale<br><span>{{ $sale }}%</span></div>
        @endif
        <div class="card-img-top d-block overflow-hidden">
            <a href="{{ route('shop.detail', $product->slug) }}">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';">
            </a>
        </div>
        <div class="card-body py-3 px-1">
            <h3 class="product-title fs-sm text-center line_3"><a href="{{ route('shop.detail', $product->slug) }}">{{ $product->name }}</a></h3>
            @if($product->promotion)
            <div class="product-price d-flex flex-wrap justify-content-center align-items-center">
                <span class="text-accent px-2">{!! render_price($product->promotion) !!}</span>
                <del class="fs-sm text-muted px-2">{!! render_price($product->price) !!}</del>
            </div>
            @elseif($product->price>0)
            <div class="product-price d-flex justify-content-center align-items-center">
                <span class="text-accent me-1">{!! render_price($product->price) !!}</span>
                @if($product->unit != '')
                <span>/ 1 {{ $product->unit }}</span>
                @endif
            </div>
            @else
            <div class="product-price d-flex justify-content-center align-items-center">
                <span class="text-accent me-1">Liên hệ</span>
            </div>
            @endif
        </div>
        @if($product->price > 0)
        <!-- <div class="product-floating-btn">
            <button class="btn btn-primary btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></button>
        </div> -->
        @endif
    </div>
</div>
