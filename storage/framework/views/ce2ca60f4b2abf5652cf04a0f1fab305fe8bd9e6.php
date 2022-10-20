<?php
  $category_id = $category->id ?? 0;
?>
<div class="offcanvas offcanvas-collapse bg-white w-100 rounded-3 py-1" id="shop-sidebar" style="max-width: 22rem;">
  <div class="offcanvas-header align-items-center shadow-sm">
    <h2 class="h5 mb-0">Filters</h2>
    <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <!-- Categories-->
    <div class="widget widget-categories mb-4 ">
      <h3 class="widget-title d-flex align-items-center">
        <img class="me-4 ms-3" src="<?php echo e(asset($templateFile .'/images/filter-icon.png')); ?>" height="12"> Danh mục
      </h3>
      <div class="accordion mt-n1" id="shop-categories">
        <?php $__currentLoopData = $categories_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="accordion-item">
          <h3 class="accordion-header">
            <?php if($category_item->children()->count()): ?>
              <a class="accordion-button collapsed <?php echo e($category_item->id == $category_id ? 'active' : ''); ?>" href="#<?php echo e($category_item->slug); ?>" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="<?php echo e($category_item->slug); ?>"><?php echo e($category_item->name); ?></a>
            <?php else: ?>
             <a class="accordion-button collapsed <?php echo e($category_item->id == $category_id ? 'active' : ''); ?>" href="<?php echo e(route('shop.detail', $category_item->slug)); ?>"><?php echo e($category_item->name); ?></a>
            <?php endif; ?>
         </h3>
         <div class="accordion-collapse collapse" id="<?php echo e($category_item->slug); ?>" data-bs-parent="#shop-categories">
           <div class="accordion-body">
             <div class="widget widget-links widget-filter">
               <ul class="widget-list widget-filter-list pt-1">
                  <li class="widget-list-item widget-filter-item">
                     <a class="widget-list-link d-flex justify-content-between align-items-center <?php echo e($category_item->id == $category_id ? 'active' : ''); ?>" href="<?php echo e(route('shop.detail', $category_item->slug)); ?>">
                        <span class="widget-filter-item-text">Xem tất cả</span>
                     </a>
                  </li>
                  <?php $__currentLoopData = $category_item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="widget-list-item widget-filter-item">
                     <a class="widget-list-link d-flex justify-content-between align-items-center <?php echo e($item->id == $category_id ? 'active' : ''); ?>" href="<?php echo e(route('shop.detail', $item->slug)); ?>">
                        <span class="widget-filter-item-text"><?php echo e($item->name); ?></span>
                     </a>
                  </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </ul>
             </div>
           </div>
         </div>
         
          
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
      </div>

    </div>
      
      
      
    </div>

</div><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/product/sidebar.blade.php ENDPATH**/ ?>