<?php
    //$galleries = $product->getGallery() ?? '';

    $spec_short = $product->spec_short ?? '';
    if($spec_short != '')
        $spec_short = json_decode($spec_short, true);
?>



<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="product-single mt-lg-3">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12 col-12 mt-lg-0 mt-3">
                <nav aria-label="breadcrumb" class="mb-3 d-md-none">
                  <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="/">Trang chủ</a></li>
                    <?php if(isset($brc) && count($brc)): ?>
                        <?php $__currentLoopData = $brc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item['url']): ?>
                            <li class="breadcrumb-item"><a href="<?php echo e($item['url']); ?>" class="text-decoration-none"><?php echo e($item['name']); ?></a></li>
                            <?php else: ?>
                            <!-- <li class="breadcrumb-item active" aria-current="page"><?php echo e($item['name']); ?></li> -->
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?> 
                  </ol>
                </nav>

                <div class="product-single-gallery">
                    <?php echo $__env->make($templatePath .'.product.product-gallery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                <nav aria-label="breadcrumb" class="mb-3 d-md-block d-none">
                  <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="/">Trang chủ</a></li>
                    <?php if(isset($brc) && count($brc)): ?>
                        <?php $__currentLoopData = $brc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item['url']): ?>
                            <li class="breadcrumb-item"><a href="<?php echo e($item['url']); ?>" class="text-decoration-none"><?php echo e($item['name']); ?></a></li>
                            <?php else: ?>
                            <!-- <li class="breadcrumb-item active" aria-current="page"><?php echo e($item['name']); ?></li> -->
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?> 
                  </ol>
                </nav>
                <?php echo $__env->make($templatePath .'.product.product-summary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 pb-5 mt-4">
                <!--Product Tabs-->
                <div class="tabs-listing">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link py-4 px-sm-4 active" href="#general" data-bs-toggle="tab" role="tab" aria-selected="false"><span>Chi tiết sản phẩm</span></a></li>
                        <li class="nav-item"><a class="nav-link py-4 px-sm-4" href="#specs" data-bs-toggle="tab" role="tab" aria-selected="true">Thành phần</a></li>
                    </ul>

                    <div class="tab-content px-lg-3">
                        <div class="tab-pane fade active show" id="general" role="tabpanel">
                            <?php echo htmlspecialchars_decode($product->content); ?>

                        </div>
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <?php if(is_array($spec_short)): ?>
                                  <div class="option_focus">
                                     <ul class="parametdesc mb-0">
                                        <?php $__currentLoopData = $spec_short; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <li class="item<?php echo e($index); ?>">
                                              <span><?php echo e($item['name'] ?? ''); ?></span>
                                              <strong><?php echo e($item['desc'] ?? ''); ?></strong>
                                           </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </ul>
                                  </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>

                </div>
                <!--End Product Tabs-->
            </div>
        </div>
        
    </div>
</div>

    <section class=" py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>SẢN PHẨM LIÊN QUAN</h3>
         </div>

         <?php if($related): ?>
            <div class="product-list product-list-5 row">
               <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-custom col-6 mb-3">
                  <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         <?php endif; ?>
      </div>
   </section>
   <?php if($product_viewed): ?>
   <section class=" py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>Vừa Mới Xem</h3>
         </div>

        
            <div class="product-list product-list-5 row">
                <?php $__currentLoopData = $product_viewed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key<5): ?>
                    <div class="col-custom col-6 mb-3">
                    <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         
      </div>
   </section>
   <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-footer'); ?>
    <script>
        $(function() {
            $(document).on('change', '.product-form__item_color input', function(event) {
                event.preventDefault();
                /* Act on the event */
                var attr_id = $(this).data('id'),
                    product = <?php echo e($product->id); ?>;
                axios({
                  method: 'post',
                  url: '<?php echo e(route('ajax.attr.change')); ?>',
                  data: {attr_id:attr_id, product:product, type:$(this).data('type')}
                }).then(res => {
                  if(res.data.error == 0){
                    $('.product-single-variations').html(res.data.view);
                  }
                }).catch(e => console.log(e));
            });

            $(document).on('change', '.available-item input', function(event) {
                event.preventDefault();

                var attr_id_change = $(this).data('id'),
                    attr_id_change_parent = $(this).data('parent');
                console.log(attr_id_change);
                $('#product_form_addCart').find('input[name="attr_id"]').attr('name', 'attr_id['+ attr_id_change_parent +']').val(attr_id_change);

                var form = document.getElementById('product_form_addCart');
                var formData = new FormData(form);
                
                axios({
                  method: 'post',
                  url: '<?php echo e(route('ajax.attr.change')); ?>',
                  data: formData
                }).then(res => {
                  if(res.data.error == 0){
                    $('.product-single-variations').html(res.data.view);
                    if(res.data.show_price != '')
                        $('.product-single__price').html(res.data.show_price);
                  }
                }).catch(e => console.log(e));
            });
            
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/product/product-single.blade.php ENDPATH**/ ?>