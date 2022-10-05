@if($priceFinal > 0)
    @php
    $price_sale = $price - $priceFinal;
    $price_percent = round($price_sale * 100 / $price);
    @endphp
    
    
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money">{!! render_price($priceFinal) !!}</span></span>
        @if(isset($unit) && $unit != '')
        <span>/ {!! $unit !!}</span>
        @endif
    </span>

    <s id="ComparePrice-product-template"><span class="money">{!! render_price($price) !!}</span></s>

    <div class="product-sale">Sale<br><span>{{ $price_percent }}%</span></div>

    {{--
    <span class="discount-badge"> <span class="devider">|</span>&nbsp;
        <span>@lang('You Save')</span>
        <span id="SaveAmount-product-template" class="product-single__save-amount">
            <span class="money">{!! render_price($price_sale) !!}</span>
        </span>
        <span class="off">(<span>{{ $price_percent }}</span>%)</span>
    </span>
    --}}
@else
    @if($price > 0)
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money">{!! render_price($price) !!}</span></span>
    </span>
    @else
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money">Liên hệ</span></span>
    </span>
    @endif
@endif