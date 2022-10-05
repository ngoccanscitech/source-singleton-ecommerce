<div class="container pt-4 pb-3 py-sm-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
            <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Home</a></li>
            <li class="breadcrumb-item text-nowrap active" aria-current="page">Cart</li>
        </ol>
    </nav>
    @if($carts->count())
    <div class="rounded-3 shadow-lg mt-4 mb-5">
        <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4 active" href="{{ route('cart') }}">1. Giỏ hàng</a></li>
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4" href="{{ route('cart.checkout') }}">2. Thanh toán</a></li>
        </ul>
        <div class="px-3 px-sm-4 px-xl-5 pt-1 pb-4 pb-sm-5">
            <form action="#" method="post" class="cart style2">
                <div class="row">
                    <!-- Items in cart-->
                    <div class="col-lg-8 col-md-7 pt-sm-2">
                        @foreach($carts as $cart)
                        @php $product = \App\Product::find($cart->id); @endphp
                        <!-- Item-->
                        @if(!empty($product))
                        <div class="cart__row_item d-sm-flex justify-content-between align-items-center mt-3 mb-4 pb-3 border-bottom">
                            <div class="d-block d-sm-flex align-items-center text-center text-sm-start">
                                @if(!empty($product->image))
                                <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="#">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';" width="120">
                                </a>
                                @endif
                                <div class="pt-2">
                                    <h3 class="product-title fs-base mb-2"><a href="#">{{ $product->name }}</a></h3>
                                    <div class="fs-sm"><span class="text-muted me-2">Đơn vị:</span>{{ $product->unit }}</div>
                                    <div class="cart__meta-text">
                                        @if ($cart->options->count())
                                            @foreach($cart->options as $groupAttr => $variable)
                                                <div>{{ $variable_group[$groupAttr] }}: {{ render_option_name($variable) }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @if(isset($variable))
                                        <div class="fs-lg text-accent pt-2">{!! render_option_price($variable) !!}</div>
                                    @else
                                        <div class="fs-lg text-accent pt-2">{!! render_price($cart->price) !!}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                                <label class="form-label" for="quantity1">Số lượng</label>
                                <input class="form-control cart__qty-input" type="number"name="updates[]" id="quantity1" value="{{ $cart->qty }}" min="1" data-rowid="{{ $cart->rowId }}">
                                <button class="btn btn-link px-0 text-danger cart__remove" type="button" data="{{ $cart->rowId }}"><i class="ci-close-circle me-2"></i><span class="fs-sm">Xóa</span></button>
                            </div>
                        </div>
                        <!-- Item-->
                            @endif
                                @endforeach
                    </div>
                    <!-- Sidebar-->
                    <div class="col-lg-4 col-md-5 pt-3 pt-sm-4">
                        <div class="rounded-3 bg-secondary px-3 px-sm-4 py-4">
                            <div class="text-center mb-4 pb-3 border-bottom">
                                <h3 class="h5 mb-3 pb-1">Thành tiền</h3>
                                <h4 class="fw-normal">{!! render_price(Cart::total(2)) !!}</h4>
                            </div>
                            {{--
                            <div class="mb-4">
                                <label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span>Thêm ghi chú</label>
                                <textarea class="form-control" rows="4" id="order-comments"></textarea>
                            </div>
                            
                            <h3 class="h6 mb-4">Apply promo code</h3>
                            <form class="needs-validation" method="post" novalidate="">
                                <div class="mb-3">
                                    <input class="form-control" type="text" placeholder="Promo code" required="">
                                    <div class="invalid-feedback">Please provide promo code.</div>
                                </div>
                                <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
                            </form>
                            --}}
                            <a class="btn btn-primary d-block w-100 mt-4 mb-3" href="{{ route('cart.checkout') }}"><i class="ci-card fs-lg me-2"></i>Thanh toán</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @else
    <div class="alert alert-danger text-uppercase mt-5" role="alert">
        <i class="ci-loudspeaker"></i> &nbsp;@lang('Cart is empty!')
    </div>
    @endif

</div>
{{--
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
            
            @if($carts->count())
            <div class="alert alert-success text-uppercase" role="alert">
                <i class="icon anm anm-truck-l icon-large"></i> &nbsp;<strong>Congratulations!</strong> You've got free shipping!
            </div>
            <form action="#" method="post" class="cart style2">
                <table class="w-100">
                    <thead class="cart__row cart__header">
                        <tr>
                            <th colspan="2" class="text-center">@lang('Product')</th>
                            <th class="text-center">@lang('Price')</th>
                            <th class="text-center">@lang('Quantity')</th>
                            <th class="text-right">@lang('Total')</th>
                            <th class="action">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        @php $product = \App\Product::find($cart->id); @endphp
                        <tr class="cart__row cart__row_item border-bottom line1 cart-flex border-top">
                            <td class="cart__image-wrapper cart-flex-item">
                                <a href="{{ route('shop.detail', $product->slug) }}"><img class="cart__image" src="{{ asset($product->image) }}" alt="{{ $product->title }}"></a>
                            </td>
                            <td class="cart__meta small--text-left cart-flex-item">
                                <div class="list-view-item__title">
                                    <a href="{{ route('shop.detail', $product->slug) }}">{{ $product->name }}</a>
                                </div>

                                <div class="cart__meta-text">
                                    @if ($cart->options->count())
                                        @foreach($cart->options as $groupAttr => $variable)
                                            <div>{{ $variable_group[$groupAttr] }}: {{ render_option_name($variable) }}</div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="cart__price-wrapper cart-flex-item">
                                @if(isset($variable))
                                <span class="money">{!! render_option_price($variable) !!}</span>
                                @else
                                <span class="money">{!! render_price($cart->price) !!}</span>
                                @endif
                            </td>
                            <td class="cart__update-wrapper cart-flex-item text-right">
                                <div class="cart__qty text-center" data="{{ $cart->rowId }}">
                                    <div class="qtyField">
                                        <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon icon-minus"></i></a>
                                        <input class="cart__qty-input qty" type="text" name="updates[]" id="qty" value="{{ $cart->qty }}" pattern="[0-9]*" readonly disabled>
                                        <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon icon-plus"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right small--hide cart-price">
                                <div><span class="money">{!! render_price($cart->qty * $cart->price) !!}</span></div>
                            </td>
                            <td class="text-center small--hide"><a href="#" class="btn btn--secondary cart__remove" data="{{ $cart->rowId }}" title="Remove tem"><i class="icon icon anm anm-times-l"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-left"><a href="{{ route('shop') }}" class="btn btn-secondary btn--small cart-continue">@lang('Continue shopping')</a></td>
                            <td colspan="3" class="text-right">
                                <a href="{{ route('carts.remove') }}" class="btn btn-secondary btn--small  small--hide">@lang('Clear Cart')</a>
                                <!-- <button type="submit" name="update" class="btn btn-secondary btn--small cart-continue ml-2">@lang('Update Cart')</button> -->
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
            @else
            <div class="alert alert-danger text-uppercase" role="alert">
                <i class="icon anm anm-truck-l icon-large"></i> &nbsp;@lang('Cart is empty!')
            </div>
            @endif
        </div>
    </div>
</div>
--}}