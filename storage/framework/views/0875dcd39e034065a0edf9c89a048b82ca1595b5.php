<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
    extract($data);
    $carts = Cart::content();
    $variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');

    $states = \App\Model\Province::get();

    if(Auth::check())
        extract(auth()->user()->toArray()); 

?>
<?php $__env->startSection('content'); ?>
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
        <form action="<?php echo e(route('cart_checkout.process')); ?>" method="post" id="form-checkout">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="shipping_cost" value="<?php echo e($data_shipping['shipping_cost']); ?>">
            <input type="hidden" name="cart_total" value="<?php echo e(Cart::total(2) + $data_shipping['shipping_cost']); ?>" data-origin="<?php echo e(Cart::total(2)); ?>">
            <input type="hidden" name="res_token" id="res_token" value="">
            <div class="container">
                <div class="row billing-fields">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                        <?php echo $__env->make($templatePath .'.cart.includes.comfirm_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="create-ac-content bg-light-gray padding-20px-all">
                            

                            <div class="msg-error mb-3" style="display: none;"></div>
                            <div class="cart-btn">
                                <!-- <button type="button" class="btn btn-info get_shipping_usps" title="Continue to shipping">Continue to shipping</button> -->
                                <button class="btn btn-primary d-block w-100 mt-3 submit-checkout" value="Place order" type="button" ><?php echo app('translator')->get('Đặt hàng'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="your-order-payment">
                            <?php echo $__env->make($templatePath .'.cart.includes.checkout_cart_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php echo $__env->make($templatePath .'.cart.includes.payment-method', ['payment_method' => $payment_method??''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
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
<script src="<?php echo e(asset($templateFile .'/js/cart.js?ver='. time())); ?>"></script>
<script>
    var strip_key = '<?php echo e(config('services.stripe')['key']); ?>';
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/cart-confirm.blade.php ENDPATH**/ ?>