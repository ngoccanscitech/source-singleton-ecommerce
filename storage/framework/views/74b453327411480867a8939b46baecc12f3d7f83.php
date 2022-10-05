<?php
$sale = 0;
if($product->promotion){
    $sale = round(100 - ($product->promotion * 100 / $product->price));
}
?>
<!-- Product-->
<div>
    <div class="card product-card card-static pb-2">
        <?php if($sale): ?>
        <div class="product-sale">Sale<br><span><?php echo e($sale); ?>%</span></div>
        <?php endif; ?>
        <div class="card-img-top d-block overflow-hidden">
            <a href="<?php echo e(route('shop.detail', $product->slug)); ?>">
                <img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
            </a>
        </div>
        <div class="card-body py-3 px-1">
            <h3 class="product-title fs-sm text-center line_3"><a href="<?php echo e(route('shop.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></h3>
            <?php if($product->promotion): ?>
            <div class="product-price d-flex flex-wrap justify-content-center align-items-center">
                <span class="text-accent px-2"><?php echo render_price($product->promotion); ?></span>
                <del class="fs-sm text-muted px-2"><?php echo render_price($product->price); ?></del>
            </div>
            <?php elseif($product->price>0): ?>
            <div class="product-price d-flex justify-content-center align-items-center">
                <span class="text-accent me-1"><?php echo render_price($product->price); ?></span>
                <?php if($product->unit != ''): ?>
                <span>/ 1 <?php echo e($product->unit); ?></span>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="product-price d-flex justify-content-center align-items-center">
                <span class="text-accent me-1">Liên hệ</span>
            </div>
            <?php endif; ?>
        </div>
        <?php if($product->price > 0): ?>
        <!-- <div class="product-floating-btn">
            <button class="btn btn-primary btn-sm" type="button">+<i class="ci-cart fs-base ms-1"></i></button>
        </div> -->
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/product/product-item.blade.php ENDPATH**/ ?>