<?php
    $category_product = Menu::getByName('Categories-product-home') ;
?>



<?php $__env->startSection('content'); ?>

<div class="main_content clear">
 <div class="body-container clear">
   
   <?php echo $__env->make($templatePath .'.parts.home-slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

   <!-- Banners-->
   <section class="container pt-4">
     <div class="row">
       <div class="col-md-6 mb-4">
         <div class="banner-item" style="background-image: url(<?php echo e(asset('/upload/images/banner-bg-1.png')); ?>); background-repeat: no-repeat;">
           <div class="py-md-4 my-2 px-md-4 text-center">
             <div class="py-1">
               <h5 class="mb-3">Bạn cần dược sĩ tư vấn ngay?</h5>
               <a class="btn btn-danger btn-radius btn-active btn-sm mb-lg-0 mb-2" href="#">Hotline 1800 6928 (miễn phí)</a>
               <a class="btn btn-info btn-radius btn-bold btn-sm mb-lg-0 mb-2" href="#">Nhắn tin</a>
             </div>
           </div>
         </div>
       </div>
       <div class="col-md-6 mb-4">
         <div class="banner-item" style="background-image: url(<?php echo e(asset('/upload/images/banner-bg-2.png')); ?>); background-repeat:no-repeat;">
           <div class="py-md-4 my-2 px-md-4 text-center">
             <div class="py-1">
               <h5 class="mb-3">Bạn có toa thuốc của bác sĩ?</h5>
               <a class="btn btn-primary btn-active btn-radius btn-sm" href="javascript:;" data-bs-toggle="modal" data-bs-target="#sendContact">Gửi hình toa thuốc</a>
             </div>
           </div>
         </div>
       </div>
     </div>
      <!-- Modal markup -->
      <div class="modal fade" tabindex="-1" role="dialog" id="sendContact">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Gửi toa thuốc</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form method="POST" action="<?php echo e(url('contact.html')); ?>" id="contactForm" enctype="multipart/form-data">
                  <?php echo csrf_field(); ?>
                  <?php echo $__env->make($templatePath .'.contact.contact_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <div class="error-message" style="display: none;"></div>
                  <div class="text-center">
                          <button type="button" class="btn btn-primary btn-send-contact">Gửi toa thuốc</button>
                      </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section id="categories">
      <div class="container">
         <?php if($categories): ?>
            <div class="categories-list categories-list-custom row">
               <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-4">
                  <?php echo $__env->make($templatePath . '.categories-home', compact('category'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         <?php endif; ?>
      </div>
   </section>

   <!-- flash sale -->
   <section id="flash_sale">
      <div class="container">
         <?php echo $__env->make($templatePath .'.parts.flash_sale', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
   </section>

   <section class="py-lg-5 py-3 bg-green">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>Dành cho bệnh nhân covid và hậu covid</h3>
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

   <section class="py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>SẢN PHẨM Bán Chạy Nhất</h3>
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

   <!-- banner -->
   <?php echo $__env->make($templatePath .'.layouts.banner_home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


   <section class="py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>Dành Cho đối tượng đặc biệt</h3>
            <div class="ml-auto d-none d-lg-block">
               <a class="btn btn-outline-secondary btn-radius btn-active ms-1" href="nft-catalog-v1.html">Trẻ em</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Người cao tuổi</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Phụ nữ cho con bú</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Người suy gan, thận</a>
            </div>
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

   <section class="bg-gray py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>sản phẩm hot theo mùa</h3>
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

   <section id="hot_news" class="py-5">
      <div class="container">
         <div class="section-title mb-lg-5 mb-3 w-100 text-center d-block">
            <h3 class="m-auto mb-3">THÔNG TIN SỨC KHOẺ</h3>
            <p>We help the world’s leading organizations follow their shipping</p>
         </div>
         <div class="row">
            <?php if($news): ?>
               <?php
               $bigPost = $news->first();
               ?>
               <div class="col-md-6">
                    <?php if($bigPost): ?>
                    <div class="post">
                        <a class="img" href="<?php echo e(route('news.single', [$bigPost->slug, $bigPost->id])); ?>" title="">
                            <img src="<?php echo e(asset($bigPost->image)); ?>" alt="" title="">
                        </a>
                        <div class="post-caption pt-3">
                            <h3 class="title"><a class="smooth" href="<?php echo e(route('news.single', [$bigPost->slug, $bigPost->id])); ?>" title=""><?php echo e($bigPost->name); ?></a></h3>
                            <div class="meta">
                                <p class="date d-flex align-items-center">
                                    <i class="ci-time me-2"></i>
                                    <?php echo e(Carbon\Carbon::parse($bigPost->created_at)->diffForHumans()); ?>

                                </p>
                                <a href="" class="btn btn-radius btn-sm"><?php echo e($bigPost->category->first()->name); ?></a>
                            </div>
                        </div>

                    </div>
                    <?php endif; ?>
               </div>
               <div class="col-md-6">
                  <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($post->id != $bigPost->id): ?>
                        <div class="post post-small mb-3">
                            <div class="img">
                                <a class="" href="<?php echo e(route('news.single', [$post->slug, $post->id])); ?>">
                                    <img src="<?php echo e(asset($post->image)); ?>" alt="">
                                </a>
                            </div>
                            <div class="post-caption">
                                <h3 class="title"><a class="smooth" href="<?php echo e(route('news.single', [$post->slug, $post->id])); ?>" title=""><?php echo e($post->name); ?></a></h3>
                                <div class="meta">
                                    <p class="date d-flex align-items-center">
                                       <i class="ci-time me-2"></i>
                                        <?php echo e(Carbon\Carbon::parse($post->created_at)->diffForHumans()); ?>

                                    </p>
                                </div>
                                <a href="" class="btn btn-radius btn-sm"><?php echo e($post->category->first()->name); ?></a>
                            </div>
                        </div>
                     <?php endif; ?>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </div>
            <?php endif; ?>
         </div>
      </div>
   </section>

   <section class="py-lg-5 py-3 bg-green">
      <div class="container py-2">
         <div class="section-title mb-3">
            <img src="<?php echo e(asset('img/title-icon.png')); ?>">
            <h3>Tìm Kiếm Hàng Đầu</h3>
         </div>

         <div class="tag-list">
            <a class="btn btn-radius" href="#">Panadol</a>
            <a class="btn btn-radius" href="#">Khẩu trang</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Nước muối</a>
            <a class="btn btn-radius" href="#">Thuốc ho, sổ mũi</a>
            <a class="btn btn-radius" href="#">Thuốc bổ phổi</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Nước muối</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Panadol</a>
         </div>
      </div>
   </section>

   <section class=" py-lg-5 py-3">
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

 </div><!--body-container-->
</div><!--main_content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/exproweb.com/public_html/nhathuockhanhkhoi/resources/views/theme/home.blade.php ENDPATH**/ ?>