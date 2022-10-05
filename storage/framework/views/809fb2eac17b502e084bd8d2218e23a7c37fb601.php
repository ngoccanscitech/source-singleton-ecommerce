<div class="category-item">
    <a href="<?php echo e(route('shop.detail', $category->slug)); ?>" title="<?php echo e($category->name); ?>">
        <div class="image">
            <?php if($category->image != ''): ?>
            <img class="rounded-3" src="<?php echo e(asset($category->image)); ?>" alt="<?php echo e($category->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
            <?php else: ?>
            <img class="rounded-3" src="<?php echo e(asset('assets/images/no-image.jpg')); ?>" alt="<?php echo e($category->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
            <?php endif; ?>
        </div>
        <div class="category-content p-3 text-center">
            <h3 class="h6 blog-entry-title mb-2"><?php echo e($category->name); ?></h3>
            <p>
                <?php if(!empty($category->products()->count())): ?>
                <?php echo e($category->products()->count()); ?>

                <?php endif; ?>
                sản phẩm</p>
        </div>
    </a>
</div><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/categories-home.blade.php ENDPATH**/ ?>