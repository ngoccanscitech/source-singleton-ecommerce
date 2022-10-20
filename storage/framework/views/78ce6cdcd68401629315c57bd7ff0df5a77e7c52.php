<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="container pt-grid-gutter mb-3">
    <div class="category-card d-flex flex-wrap justify-content-md-between">
        <?php $__currentLoopData = $categories_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-item <?php echo e($category->id == $item->id ? 'active' : ''); ?>">
            <a class="h-100" href="<?php echo e(route('shop.detail', $item->slug)); ?>" data-scroll>
                <div class="p-2 text-center">
                    <!-- <i class="ci-location h3 mt-2 mb-4 text-primary"></i> -->
                    <img class="mb-3" src="<?php echo e(asset($templateFile .'/images/flower-icon.png')); ?>" height="30">
                    <h3 class="card-title mb-2"><?php echo e($item->name); ?></h3>
                    <p class="fs-sm text-muted"><?php echo e($item->products()->count()); ?> sản phẩm</p>
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<div class="container">
    <div class="row">
        <aside class="col-lg-3">
            <?php echo $__env->make($templatePath .'.product.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </aside>



        <section class="col-lg-9">
                <form action="" method="get">
                    <div class="collection-header mt-2 mb-4">
                        <div class="d-flex flex-wrap justify-content-end">
                            <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4">
                                <label class="fs-sm text-nowrap me-2 d-none d-sm-block" for="sorting">SẮP XẾP THEO:</label>
                                <select class="form-select" id="sorting" name="sort" onchange="this.form.submit()">
                                    <option value="id__desc" <?php echo e(request('sort') == 'id__desc' ? 'selected' : ''); ?>>Mới nhất</option>
                                    <option value="id__asc" <?php echo e(request('sort') == 'id__asc' ? 'selected' : ''); ?>>Cũ nhất</option>
                                    <option value="price__asc" <?php echo e(request('sort') == 'price__asc' ? 'selected' : ''); ?>>Giá tăng dần</option>
                                    <option value="price__desc" <?php echo e(request('sort') == 'price__desc' ? 'selected' : ''); ?>>Giá giảm dần</option>
                                    <option value="name__desc" <?php echo e(request('sort') == 'name__desc' ? 'selected' : ''); ?>>Từ A - Z</option>
                                    <option value="name__asc" <?php echo e(request('sort') == 'name__asc' ? 'selected' : ''); ?>>Từ Z - A</option>
                                </select>
                            </div>
                          </div>
                    </div>
                </form>
                <!--End Collection Banner-->
                    <div class="product-list row">
                       <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="col-lg-3 col-6 mb-3">
                          <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          </div>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <!--Pagination-->
                <hr class="clear">
                <?php echo $products->withQueryString()->links(); ?>

        </section>
    </div>
</div>

<section class=" py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>Vừa Mới Xem</h3>
         </div>

         <?php if($products): ?>
            <div class="product-list product-list-5 row">
               <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-custom col-6 mb-3">
                  <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         <?php endif; ?>
      </div>
   </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/product/product-category.blade.php ENDPATH**/ ?>