<?php
    $menu_main = Menu::getByName('Menu-main') ;
?>
<!-- Navbar 3 Level (Light)-->
<header class="shadow-sm">

<!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
<div class="navbar-sticky bg-light position-relative">
    <div class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand d-none d-sm-inline-block flex-shrink-0" href="/">
                <img src="<?php echo e(setting_option('logo')); ?>" width="142" alt="<?php echo e(setting_option('name-company')); ?>">
            </a>
            <a class="navbar-brand d-sm-none flex-shrink-0 me-2" href="/">
                <img src="<?php echo e(setting_option('logo')); ?>" width="74" alt="<?php echo e(setting_option('name-company')); ?>">
            </a>
            <a href="/" class="domain-name">thuocnhanh<span>5p</span>.com</a>

            <form class="search-top d-none d-lg-flex mx-4 w-100">
                <div class="input-group ">
                    <input class="form-control rounded-end pe-5" type="text" placeholder="Nhập tên sản phẩm bạn cần tìm...">
                    <span class="icon-search position-absolute top-50 end-0 translate-middle-y text-muted fs-base ">
                        <i class="ci-search"></i>
                        Tìm kiếm
                    </span>
                </div>
            </form>

            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-tool navbar-stuck-toggler" href="#"><span class="navbar-tool-tooltip">Expand menu</span>
                <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-menu"></i></div></a>
                <?php if(Auth::check()): ?>
                  <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="<?php echo e(route('customer.profile')); ?>" >
                     <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-user"></i></div>
                     <div class="navbar-tool-text ms-n3"><?php echo e(request()->user()->fullname); ?></div>
                  </a>
                <?php else: ?>
                <a class="navbar-tool ms-1 ms-lg-0 me-n1 me-lg-2" href="#signin-modal" data-bs-toggle="modal">
                    Đăng nhập/ Đăng ký
                </a>
                <?php endif; ?>

                <div class="navbar-tool dropdown ms-3 site-cart">
                    <a class="navbar-tool-icon-box dropdown-toggle" href="<?php echo e(route('cart')); ?>">
                        <span class="navbar-tool-label" id="CartCount"><?php echo e(Cart::count()); ?></span>
                        <!-- <i class="navbar-tool-icon ci-cart"></i> -->
                        <img src="<?php echo e(asset($templateFile .'/images/icon-cart.png')); ?>">
                    </a>
                    <a class="navbar-tool-text" href="shop-cart.html">Giỏ hàng</a>
                    <?php echo $__env->make($templatePath .'.cart.cart-mini', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu d-block">
        <div class="menu-main">
            <div class="menu-content">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <!-- Search-->
                    <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                      <input class="form-control rounded-start" type="text" placeholder="Search for products">
                    </div>
                    <!-- Departments menu-->
                    <ul class="navbar-nav navbar-mega-nav pe-lg-2 me-lg-2">
                      <li class="nav-item dropdown"><a class="nav-link dropdown-toggle ps-lg-0" href="#" data-bs-toggle="dropdown">DANH MỤC SẢN PHẨM</a>
                        <div class="dropdown-menu p-3 pb-1">
                          <div class="d-flex flex-wrap flex-sm-nowrap">
                            
                            <div class="mega-dropdown-column">
                              <div class="widget widget-links">
                                <ul class="widget-list">
                                  <?php $__currentLoopData = $menu_main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <li class="widget-list-item mb-2"><a class="widget-list-link" href="<?php echo e(url($menu['link'])); ?>"><?php echo e($menu['label']); ?></a></li>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
            </div>
            <div class="slogan">
                <span>"Tư vấn tận tâm - Giao thuốc nhanh chóng"</span>
            </div>
        </div>
  </div>
</div>
</header>

<?php if(!Auth::check()): ?>
<div class="modal fade" id="signin-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link fw-medium active" href="#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true"><i class="ci-unlocked me-2 mt-n1"></i>Sign in</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium" href="#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false"><i class="ci-user me-2 mt-n1"></i>Sign up</a></li>
                </ul>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body tab-content py-4">
                <form action="" class="needs-validation tab-pane fade active show" autocomplete="off" novalidate="" id="signin-tab">
                    <div class="mb-3">
                        <label class="form-label" for="si-email">Email</label>
                        <input class="form-control" type="email" id="si-email" name="email" placeholder="text@example.com" required="">
                        <div class="invalid-feedback">Nhập địa chỉ Email của bạn.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="si-password">Password</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="si-password" name="password" required="">
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-wrap justify-content-between">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="si-remember">
                            <label class="form-check-label" for="si-remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a class="fs-sm" href="#">Quên mật khẩu?</a>
                    </div>
                    <div class="error-message" style="display: none;"></div>
                    <button class="btn btn-primary d-block w-100 btn-login" type="button">Đăng nhập</button>
                </form>
                <form class="needs-validation tab-pane fade" autocomplete="off" novalidate="" id="signup-tab">
                    <div class="mb-3">
                        <label class="form-label" for="su-name">Họ tên</label>
                        <input class="form-control" type="text" id="su-name" placeholder="Họ tên" required="">
                        <div class="invalid-feedback">Vui lòng nhập họ tên.</div>
                    </div>
                    <div class="mb-3">
                        <label for="su-email">Email</label>
                        <input class="form-control" type="email" id="su-email" placeholder="text@example.com" required="">
                        <div class="invalid-feedback">Nhập địa chỉ Email của bạn.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="su-password">Mật khẩu</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="su-password" required="">
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="su-password-confirm">Xác nhận mật khẩu</label>
                        <div class="password-toggle">
                            <input class="form-control" type="password" id="su-password-confirm" required="">
                            <label class="password-toggle-btn" aria-label="Show/hide password">
                            <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-primary d-block w-100" type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/layouts/header.blade.php ENDPATH**/ ?>