
<?php if(isset($product)): ?>   
   <?php if(count($product->getGallery())): ?>
      <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">

         <?php $__currentLoopData = $product->getGallery(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div
          class="carousel__slide"
          data-src="<?php echo e(asset($image)); ?>"
          data-fancybox="gallery">
            <img src="<?php echo e(asset($image)); ?>" width="100%" height="100%" />
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
         <?php $__currentLoopData = $product->getGallery(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel__slide">
               <img class="panzoom__content" src="<?php echo e(asset($image)); ?>" width="100%" height="100%" />
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      
   <?php else: ?>
      <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
         <div
          class="carousel__slide"
          data-src="<?php echo e(asset($product->image)); ?>"
          data-fancybox="gallery">
            <img src="<?php echo e(asset($product->image)); ?>" width="100%" height="100%" alt="" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';">
         </div>
      </div>
   <?php endif; ?>
<?php endif; ?>

<?php $__env->startPush('head-style'); ?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-footer'); ?>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script defer>
   jQuery(document).ready(function($) {
      var mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
              Dots: false,
            });

            // Thumbnails
            var thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
              Sync: {
                target: mainCarousel,
                friction: 0,
              },
              Dots: false,
              Navigation: false,
              center: true,
              slidesPerPage: 1,
              infinite: false,
            });

            // Customize Fancybox
            Fancybox.bind('[data-fancybox="gallery"]', {
              Carousel: {
                on: {
                  change: (that) => {
                    mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                      friction: 0,
                    });
                  },
                },
              },
            });
   });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/product/product-gallery.blade.php ENDPATH**/ ?>