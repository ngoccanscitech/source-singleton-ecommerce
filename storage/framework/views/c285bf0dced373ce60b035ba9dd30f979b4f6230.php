<?php
    $carts = Cart::content();
    //$variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
?>

<!-- Cart dropdown-->
<div class="dropdown-menu dropdown-menu-end" id="header-cart">
    <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
        <div data-simplebar="init" data-simplebar-auto-hide="false">
            <div class="simplebar-wrapper" style="margin: 0px -16px 0px 0px;">
                <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset">
                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content">
                            <div class="simplebar-content mini-products-list">
        
                                <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $product = \App\Product::find($cart->id); ?>
                                <?php if(!empty($product)): ?>
                                    <div class="widget-cart-item py-2 border-bottom">
                                      <button class="btn-close text-danger remove" type="button" aria-label="Remove" data="<?php echo e($cart->rowId); ?>"><span aria-hidden="true">×</span></button>
                                      <div class="d-flex align-items-center">
                                          <?php if(!empty($product->image)): ?>
                                        <a class="flex-shrink-0" href="shop-single-v1.html">
                                            <img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';" width="64">
                                        </a>
                                          <?php endif; ?>
                                        <div class="ps-2">
                                          <h6 class="widget-product-title"><a href="shop-single-v1.html"><?php echo e($product->name); ?></a></h6>
                                          <div class="widget-product-meta"><span class="text-accent me-2"><?php echo render_price($cart->price * $cart->qty); ?></span><span class="text-muted">x <?php echo e($cart->qty); ?></span></div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>    
            </div>
        </div>
        <?php if($carts->count()): ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
            <div class="fs-sm me-2 py-2 total">
                <span class="text-muted">Thành tiền:</span>
                <span class="text-accent fs-base ms-1 money-total"><?php echo render_price(Cart::total(2)); ?></span>
            </div>
            <a class="btn btn-outline-secondary btn-sm" href="<?php echo e(route('cart')); ?>">Xem giỏ hàng<i class="ci-arrow-right ms-1 me-n1"></i></a>
        </div>
        <a class="btn btn-primary btn-sm d-block w-100" href="<?php echo e(route('cart.checkout')); ?>">
            <i class="ci-card me-2 fs-base align-middle"></i>Checkout
        </a>
        <?php else: ?>
        <div class="text-center">Giỏ hàng rỗng</div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/cart-mini.blade.php ENDPATH**/ ?>