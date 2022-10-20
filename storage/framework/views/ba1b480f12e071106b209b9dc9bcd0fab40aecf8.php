<?php
$banner_menu = Menu::getByName('Banner-home');
?>
<?php if($banner_menu): ?>
<section>
   <div class="container">
      <div class="row">

         <div class="col-lg-8">
            <div class="row">
               <?php if(isset($banner_menu[0])): ?>
               <div class="col-md-8 mb-4">
                  <div class="banner-ads py-5 d-flex h-100 justify-content-end bg-size-cover bg-position-center rounded-3" 
                     style="background-image: url(<?php echo e(asset($banner_menu[0]['icon'])); ?>);">
                     <div class="py-4 my-2 pe-5">
                        <div class="py-1">
                           <p class="fs-sm text-muted mb-2"><?php echo e($banner_menu[0]['content']); ?></p>
                           <h5 class="mb-3"><?php echo $banner_menu[0]['label']; ?></h5>
                           <a class="btn btn-primary btn-radius opacity-80" href="#">Buy now <i class="ci-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endif; ?>
               <?php if(isset($banner_menu[1])): ?>
               <?php $banner = $banner_menu[1] ?>
               <div class="col-md-4 mb-4">
                  <div class="banner-ads py-3 d-flex h-100 bg-size-cover bg-position-center rounded-3" 
                     style="background-image: url(<?php echo e(asset($banner['icon'])); ?>);">
                     <div class="py-2 my-2 px-4">
                        <div class="py-1">
                           <p class="fs-sm text-muted mb-2"><?php echo $banner['content']; ?></p>
                           <h5 class="mb-3"><?php echo $banner['label']; ?></h5>
                           <!-- <a class="btn btn-primary btn-radius btn-sm" href="#">Buy now</a> -->
                        </div>
                     </div>
                  </div>
               </div>
               <?php endif; ?>
               <?php if(isset($banner_menu[2])): ?>
               <?php $banner = $banner_menu[2] ?>
               <div class="col-md-5 mb-4">
                  <div class="banner-ads pb-5 d-flex h-100 bg-size-cover bg-position-center rounded-3" 
                     style="background-image: url(<?php echo e(asset($banner['icon'])); ?>);">
                     <div class="py-4 my-2 px-4">
                        <div class="py-1">
                           <p class="fs-sm text-muted mb-2"><?php echo $banner['content']; ?></p>
                           <h5 class="mb-3"><?php echo $banner['label']; ?></h5>
                           <a class="btn btn-primary btn-radius opacity-80" href="#">Buy now <i class="ci-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endif; ?>
               <?php if(isset($banner_menu[3])): ?>
               <?php $banner = $banner_menu[3] ?>
               <div class="col-md-7 mb-4">
                  <div class="banner-ads py-5 d-flex flex-column h-100 bg-size-cover bg-position-center rounded-3" 
                     style="background-image: url(<?php echo e(asset($banner['icon'])); ?>);">
                     <div class=" my-2 px-4">
                        <div class="py-1">
                           <p class="fs-sm text-muted mb-2"><?php echo $banner['content']; ?></p>
                           <h5 class="mb-3"><?php echo $banner['label']; ?></h5>
                           <!-- <a class="btn btn-primary btn-radius btn-sm" href="#">Buy now</a> -->
                        </div>
                     </div>
                  </div>
               </div>
               <?php endif; ?>
            </div>
         </div>
         <?php if(isset($banner_menu[4])): ?>
               <?php $banner = $banner_menu[4] ?>
               <div class="col-md-4 mb-4">
                  <div class="banner-ads pb-5 d-flex h-100 bg-size-cover bg-position-center rounded-3" 
                     style="background-image: url(<?php echo e(asset($banner['icon'])); ?>);">
                     <div class="py-4 my-2 px-4">
                        <div class="py-1">
                           <div class="fs-sm text-muted mb-2"><?php echo $banner['content']; ?></div>
                           <h5 class="mb-3"><?php echo $banner['label']; ?></h5>
                           <a class="btn btn-primary btn-radius opacity-80" href="#">Buy now <i class="ci-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php endif; ?>

      </div>
   </div>

</section>
<?php endif; ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/layouts/banner_home.blade.php ENDPATH**/ ?>