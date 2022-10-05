<ul id="muti_menu_post" class="muti_menu_right_category">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $checked = '';
        if(in_array($category->id, $array_checked))
            $checked = 'checked';
    ?>
    <li class="category_menu_list">
        <label for="checkbox_cmc_<?php echo e($category->id); ?>">
            <input type="checkbox" class="category_item_input" name="category_item[]" value="<?php echo e($category->id); ?>" id="checkbox_cmc_<?php echo e($category->id); ?>" <?php echo e($checked); ?>>
            <span><?php echo e($category->name); ?></span>
        </label>

        <?php if($category->children->count()): ?>
            <?php echo $__env->make('admin.product.includes.category-item', ['categories' => $category->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/product/includes/category-item.blade.php ENDPATH**/ ?>