


<?php $__env->startSection('seo'); ?>
    <title>Search</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="space-ptb bg-light ">
        <div class="container">
            <div class="row align-items-center justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <div class="section-title mb-0 mt-4">
                        <h3 class="d-inline">Tìm kiếm</h3>
                    </div>
                </div>
            </div>
            <div class="mb-3">
               Tìm kiếm với từ khóa: <b>"<?php echo e($keyword??''); ?>"</b>
            </div>

            <div class="grid-products grid--view-items">
                <div class="row">
                    <?php if(isset($products)): ?>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-sm-6 col-md-3 item">
                            <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($products->count()): ?>
            <div class="row">
                <div class="col-12">
                    <hr class="clear">
                    <?php echo $products->appends(request()->input())->links(); ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php $__env->startPush('after-footer'); ?>
    <script src="<?php echo e(asset('theme/js/customer.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/search.blade.php ENDPATH**/ ?>