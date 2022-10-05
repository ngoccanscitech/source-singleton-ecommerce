@php
    $carts = Cart::content();
    //$variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
@endphp

<!-- Cart dropdown-->
<div class="dropdown-menu dropdown-menu-end" id="header-cart">
    <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
        <div data-simplebar="init" data-simplebar-auto-hide="false">
            <div class="simplebar-wrapper" style="margin: 0px -16px 0px 0px;">
                <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset">
                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
                            <div class="simplebar-content mini-products-list">
        
                                @foreach($carts as $cart)
                                    @php $product = \App\Product::find($cart->id); @endphp
                                @if(!empty($product))
                                    <div class="widget-cart-item py-2 border-bottom">
                                      <button class="btn-close text-danger remove" type="button" aria-label="Remove" data="{{ $cart->rowId }}"><span aria-hidden="true">×</span></button>
                                      <div class="d-flex align-items-center">
                                          @if(!empty($product->image))
                                        <a class="flex-shrink-0" href="shop-single-v1.html">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';" width="64">
                                        </a>
                                          @endif
                                        <div class="ps-2">
                                          <h6 class="widget-product-title"><a href="shop-single-v1.html">{{ $product->name }}</a></h6>
                                          <div class="widget-product-meta"><span class="text-accent me-2">{!! render_price($cart->price * $cart->qty) !!}</span><span class="text-muted">x {{ $cart->qty }}</span></div>
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>    
            </div>
        </div>
        @if($carts->count())
        <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
            <div class="fs-sm me-2 py-2 total">
                <span class="text-muted">Thành tiền:</span>
                <span class="text-accent fs-base ms-1 money-total">{!! render_price(Cart::total(2)) !!}</span>
            </div>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('cart') }}">Xem giỏ hàng<i class="ci-arrow-right ms-1 me-n1"></i></a>
        </div>
        <a class="btn btn-primary btn-sm d-block w-100" href="{{ route('cart.checkout') }}">
            <i class="ci-card me-2 fs-base align-middle"></i>Checkout
        </a>
        @else
        <div class="text-center">Giỏ hàng rỗng</div>
        @endif
    </div>
</div>
