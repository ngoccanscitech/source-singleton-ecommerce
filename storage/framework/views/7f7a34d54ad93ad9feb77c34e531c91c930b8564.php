<?php
    $partners = \App\Model\Slider::where('status', 0)->where('slider_id', 59)->orderBy('order','asc')->get();
    $menu_footer_main = Menu::getByName('Menu-main');
    $menu_footer = Menu::getByName('Menu-footer');
?>

<!-- Footer-->
<footer class="footer bg-blue">
  <div class="pt-5">
        <div class="container">
            <div class="row pb-3">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e(asset('upload/images/contents/khau-trang.png')); ?>">
                        <div class="ps-3">
                            <h6 class="footer-title text-light mb-1">THUỐC CHÍNH HÃNG</h6>
                            <p class="mb-0 fs-ms text-light">đa dạng và chuyên sâu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e(asset('upload/images/contents/doi-tra.png')); ?>">
                        <div class="ps-3">
                            <h6 class="footer-title text-light mb-1">ĐỔI TRẢ TRONG 30 NGÀY</h6>
                            <p class="mb-0 fs-ms text-light">kể từ ngày mua hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="d-flex align-items-center">
                        <!-- <i class="ci-support text-white" style="font-size: 2.25rem;"></i> -->
                        <img src="<?php echo e(asset('upload/images/contents/cam-ket.png')); ?>">
                        <div class="ps-3">
                            <h6 class="footer-title text-light mb-1">CAM KẾT 100%</h6>
                            <p class="mb-0 fs-ms text-light">chất lượng sản phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e(asset('upload/images/contents/van-chuyen.png')); ?>">
                        <div class="ps-3">
                            <h6 class="footer-title text-light mb-1">MIỄN PHÍ VẬN CHUYỂN</h6>
                            <p class="mb-0 fs-ms text-light">theo chính sách giao hàng</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="hr-light mb-5">
        </div>
    </div>
    <div class="container footer-bottom">
        <div class="row pb-2">
            <div class="col-md-6 col-sm-6">
                <div class="widget widget-links widget-light pb-2">
                    <h3 class="widget-title text-light">Shop departments</h3>
                    <div class="text-white">
                      <?php echo htmlspecialchars_decode(setting_option('footer-company-info')); ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="row">
                <div class="col-lg-8">
                  <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">VỀ CHÚNG TÔI</h3>
                    <ul class="widget-list widget-list-2">
                      <?php $__currentLoopData = $menu_footer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e($menu['link']); ?>"><?php echo e($menu['label']); ?></a></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="widget widget-links widget-light pb-2 mb-4">
                    <h3 class="widget-title text-light">DANH MỤC</h3>
                    <ul class="widget-list">
                        <?php $__currentLoopData = $menu_footer_main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="widget-list-item"><a class="widget-list-link" href="<?php echo e($menu['link']); ?>"><?php echo e($menu['label']); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </div>
                </div>
              </div>
                
                
            </div>
        </div>
    </div>
    
</footer>

<?php echo htmlspecialchars_decode(setting_option('plugin-social-icon')); ?>

<?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/layouts/footer.blade.php ENDPATH**/ ?>