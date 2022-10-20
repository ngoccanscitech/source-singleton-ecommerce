<div class="category-item">
    <a href="<?php echo e(route('shop.detail', $category->slug)); ?>" title="<?php echo e($category->name); ?>">
        <div class="image">
            <div class="image-item">
                <?php if($category->image != ''): ?>
                <img class="rounded-3" src="<?php echo e(asset($category->image)); ?>" alt="<?php echo e($category->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
                <?php else: ?>
                <img class="rounded-3" src="<?php echo e(asset('assets/images/no-image.jpg')); ?>" alt="<?php echo e($category->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
                <?php endif; ?>
            </div>
        </div>
        <div class="category-content p-3 text-center">
            <h3 class="h6 blog-entry-title mb-2"><?php echo e($category->name); ?></h3>
            <?php if($category->products()->count()): ?>
            <p><?php echo e($category->products()->count()); ?> sản phẩm</p>
            <?php endif; ?>
        </div>
    </a>
</div><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/categories-home.blade.php ENDPATH**/ ?>