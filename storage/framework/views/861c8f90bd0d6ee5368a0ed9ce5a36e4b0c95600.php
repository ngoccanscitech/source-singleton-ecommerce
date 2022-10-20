<?php
   $alias = $alias??'';
?>
<?php if($alias != ''): ?>
   <?php
      $alias = str_replace('.html', '', $alias);
      $category_item = ( new \App\ProductCategory )->getDetail($alias, $type='slug');
      if($category_item)
         $category_products = $category_item->products()->limit(10)->get();
   ?>
   <?php if($category_item && $category_products->count()): ?>
   <section class="py-lg-5 py-3 <?php echo e($bg??'bg-green'); ?> <?php echo e($alias); ?>">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3><?php echo e($category_menu['label']??''); ?></h3>
            <?php if(isset($category_menu['child']) && $category_menu['child']): ?>
            <div class="ms-auto d-none d-lg-block">
               <?php $__currentLoopData = $category_menu['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category_child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="<?php echo e(url($category_child['link'])); ?>"><?php echo e($category_child['label']); ?></a>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
         </div>

         
            <div class="product-list product-list-5 row">
               <?php $__currentLoopData = $category_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-custom col-6 mb-3">
                  <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         
      </div>
   </section>
   <?php endif; ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/category-product-home.blade.php ENDPATH**/ ?>