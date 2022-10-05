<ul class="list-group mb-3">
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                <div class="d-flex">
                    <div style="width: 150px;">Người nhận</div>
                    <div style="flex: 1;">
                        <div>Họ tên: <?php echo e($ship_name ?? ''); ?></div>
                        <div>Điện thoại: <?php echo e($ship_phone ?? ''); ?></div>
                        <div>Email: <?php echo e($email ?? ''); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-2 text-right">
                <?php if(isset($product)): ?>
                <a href="<?php echo e(route('shop.buyNow', $product->id)); ?>" title="">Thay đổi</a>
                <?php else: ?>
                <a href="<?php echo e(route('cart.checkout')); ?>" title="">Thay đổi</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                <div class="d-flex">
                    <div style="width: 150px;">
                        <?php if($delivery == 'shipping'): ?>
                            <?php echo app('translator')->get('Giao hàng nhanh'); ?>
                        <?php else: ?>
                            <?php echo app('translator')->get('Pick up'); ?>
                        <?php endif; ?>
                    </div>
                    <div style="flex: 1;">
                        <?php if($delivery == 'shipping'): ?>
                        <?php
                        $state = \App\Model\Province::where('name', $state_province)->first();
                        ?>
                            <span><?php echo e(implode(', ', array_filter([$address_line1, $state_province]))); ?></span>
                        <?php else: ?>
                            <?php echo htmlspecialchars_decode(setting_option('pickup_address')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-2 text-right">
                <?php if(isset($product)): ?>
                <a href="<?php echo e(route('shop.buyNow', $product->id)); ?>" title="">Thay đổi</a>
                <?php else: ?>
                <a href="<?php echo e(route('cart.checkout')); ?>" title="">Thay đổi</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
</ul><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/includes/comfirm_user.blade.php ENDPATH**/ ?>