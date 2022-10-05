<?php
    $sliders = \App\Model\Slider::where('status', 0)->where('slider_id', 42)->orderBy('order','asc')->get();
?>
<?php if($sliders->count()): ?>
<!--Home slider-->

      <section class="tns-carousel tns-controls-lg">
        <div class="tns-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;responsive&quot;: {&quot;0&quot;:{&quot;nav&quot;:true, &quot;controls&quot;: false},&quot;992&quot;:{&quot;nav&quot;:false, &quot;controls&quot;: true}}}">
            <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Item-->
            <div class="px-lg-5" style="background: url(<?php echo e($slider->src); ?>);">
                <div class="d-lg-flex justify-content-between align-items-center ps-lg-4">
                    <div class="position-relative me-lg-n5 py-5 px-4 order-lg-1">
                        <div class="pb-lg-5 mb-lg-5 text-center text-lg-start text-lg-nowrap">
                            <h3 class="h2 pb-1 from-start text-">Tư vấn tận tâm</h3>
                            <h2 class=" display-5 from-top delay-1 text-">Giao thuốc nhanh chóng</h2>
                            
                            <div class="d-table scale-up delay-4 mx-auto"><a class="btn btn-primary" href="#">Mua thuốc ngay</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </section>
<!--End Home slider-->
<?php endif; ?><?php /**PATH /home/admin/domains/exproweb.com/public_html/nhathuockhanhkhoi/resources/views/theme/parts/home-slider.blade.php ENDPATH**/ ?>