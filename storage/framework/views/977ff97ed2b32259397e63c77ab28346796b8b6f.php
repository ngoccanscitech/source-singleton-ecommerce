<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
    $carts = Cart::content();
    $variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');

    $states = \App\Model\Province::get();

    if(Auth::check())
        extract(auth()->user()->toArray());

?>
<?php $__env->startSection('content'); ?>
    <div class="container pt-4 pb-3 py-sm-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Home</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="<?php echo e(route('cart')); ?>">Giỏ hàng</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Đặt hàng</li>
            </ol>
        </nav>
        <div class="rounded-3 shadow-lg mt-4 mb-5">
            <ul class="nav nav-tabs nav-justified mb-sm-4">
                <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4" href="<?php echo e(route('cart')); ?>">1. Giỏ hàng</a></li>
                <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4 active" href="<?php echo e(route('cart.checkout')); ?>">2. Đặt hàng</a></li>
            </ul>
            <form class="needs-validation px-3 px-sm-4 px-xl-5 pt-sm-1 pb-4 pb-sm-5" action="<?php echo e(route('cart.checkout.confirm')); ?>" method="post" id="form-checkout">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="shipping_cost" value="0">
                <input type="hidden" name="cart_total" value="<?php echo e(Cart::total(2)); ?>" data-origin="<?php echo e(Cart::total(2)); ?>">
                <input type="hidden" name="res_token" id="res_token" value="">
                <div class="row billing-fields">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                        <?php echo $__env->make($templatePath . '.cart.includes.cart-shipping', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                        <div class="your-order-payment">
                            <?php echo $__env->make($templatePath .'.cart.includes.checkout_cart_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php echo $__env->make($templatePath .'.cart.includes.payment-method', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-style'); ?>
<link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/cart.css')); ?>">
<style>
    .msg-error{
        color: #f00;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-footer'); ?>
<script type="application/javascript" src = "https://checkout.stripe.com/checkout.js" > </script> 
<script src="<?php echo e(asset('/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset($templateFile .'/js/cart.js?ver='. time())); ?>"></script>

<script>
    var strip_key = '<?php echo e(config('services.stripe')['key']); ?>';
    jQuery(document).ready(function($) {
        $('input[name="delivery"]:checked').parent().find('.ship-content').show();
        $('input[name="payment_method"]:checked').parent().find('.payment-content').show();

        $('input[name="payment_method"]').on('change', function(){
            $('.payment-content').hide();
            $(this).parent().find('.payment-content').show();
        });

        $('input[name="delivery"]').on('change', function(){
            $('.ship-content').hide();
            $(this).parent().find('.ship-content').show();
            var val = $(this).val();
            $('.delivery_content').hide();
            $('.'+ val + '_content').show();
            if(val == 'pick_up'){
                $('.get_shipping_cost').hide();
                $('.submit-checkout').show();
                $('.shipping_cost').text(0);
                $('.cart_total').html('<?php echo render_price(Cart::total(2)); ?>');
                $('input[name="cart_total"]').val('<?php echo e(Cart::total(2)); ?>');
            }
            else{
                $('.get_shipping_cost').show();
                $('.submit-checkout').hide();
                $('.shipping_cost').text('Calculated at next step');
            }
        });

        
        $(document).on('change', '.shipping-list input', function(){
            var price = $(this).val();
            var total = $('input[name="cart_total"]').data('origin');

            $('.shipping_cost').text('$' + price);
            $('input[name="shipping_cost"]').val(price);

            total = parseFloat(total) + parseFloat(price);
            $('.cart_total').text( '$' + total );
            $('input[name="cart_total"]').val( total );
        });
    });
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/checkout.blade.php ENDPATH**/ ?>