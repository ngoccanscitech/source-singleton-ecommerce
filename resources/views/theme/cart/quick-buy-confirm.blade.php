@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@php
    extract($data);
    $carts = Cart::content();
    $variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');

    $states = \App\Model\State::get();

    if(Auth::check())
        extract(auth()->user()->toArray());

    $option = session()->get('option');
    if(is_array($option))
        $option = json_decode($option[0], true);


    $price_total = $option['price'] ?? $product->price;
    $total = $price_total * $option['qty'];

@endphp
@section('content')
<div id="page-content" class="page-template page-checkout">
    <div class="container pt-4 pb-3 py-sm-4">
        <!--Page Title-->
        <div class="page section-header text-center">
            <div class="page-title">
                <div class="wrapper">
                    <h3 class="page-width mb-5">Xác nhận đơn hàng</h3>
                </div>
            </div>
        </div>
        <!--End Page Title-->
        <form action="{{ route('cart_checkout.process') }}" method="post" id="form-checkout">
            @csrf()
            <input type="hidden" name="shipping_cost" value="{{ $data_shipping['shipping_cost'] }}">
            <input type="hidden" name="cart_total" value="{{ $total + $data_shipping['shipping_cost'] }}" data-origin="{{ $total }}">
            <input type="hidden" name="res_token" id="res_token" value="">
            <div class="container">
                <div class="row billing-fields">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                        @include($templatePath .'.cart.includes.comfirm_user')

                        <div class="create-ac-content bg-light-gray padding-20px-all">
                            

                            <div class="msg-error mb-3" style="display: none;"></div>
                            <div class="cart-btn">
                                <button class="btn btn-primary d-block w-100 mt-3 submit-checkout" value="Place order" type="button" >@lang('Đặt hàng')</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="your-order-payment">
                            @include($templatePath . '.cart.includes.quick_buy_cart_item')
                            @include($templatePath .'.cart.includes.payment-method', ['payment_method' => $payment_method??''])

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('head-style')
<link rel="stylesheet" href="{{ url($templateFile .'/css/cart.css') }}">
<style>
    .msg-error{
        color: #f00;
    }
</style>
@endpush
@push('after-footer')
<script type="application/javascript" src = "https://checkout.stripe.com/checkout.js" > </script> 
<script src="{{ asset($templateFile .'/js/cart.js?ver='. time()) }}"></script>
<script>
    var strip_key = '{{ config('services.stripe')['key'] }}';
    jQuery(document).ready(function($) {
        $(document).on('change', '.shipping-list input', function(){
            var price = $(this).val().split('__')[0];
            var total = $('input[name="cart_total"]').data('origin');


            $('.shipping_cost').text('$' + price);
            $('input[name="shipping_cost"]').val(price);

            total = parseFloat(total) + parseFloat(price);
            $('.cart_total').text( '$' + total );
            $('input[name="cart_total"]').val( total );
        });
    });

    window.addEventListener("pageshow", function(event) {
        var historyTraversal = event.persisted ||
            (typeof window.performance != "undefined" &&
            window.performance.navigation.type === 2);
        if (historyTraversal) {
            window.location.reload();
           
        }
    });
</script>
@endpush
