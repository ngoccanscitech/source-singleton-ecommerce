<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id='page-content'>
        <div class="page-wrapper container my-5">
            <div class="row">
                <div class="col-12 mx-auto">
                    <?php echo htmlspecialchars_decode($content_success->content); ?>

                    <div class="text-center">
                        <a href="<?php echo e(route('request_payment_success', $cart->cart_code)); ?>" class="btn btn-primary">Gửi xác nhận đã thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/checkout-success.blade.php ENDPATH**/ ?>