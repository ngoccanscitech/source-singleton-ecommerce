<div class="your-order">
    <h4 class="order-title mb-4">Đơn hàng</h4>

    <div class="table-responsive-sm order-table">
        <table class="bg-white table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th class="text-left">Tên SP</th>
                    <th width="20%">Giá</th>
                    <th width="15%">Đơn vị</th>
                    <th>SL</th>
                    <th width="20%">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $weight = 0; ?>
                <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $product = \App\Product::find($cart->id); $weight = $weight + ($product->weight * $cart->qty ) ;?>
                <tr>
                    <td class="text-left"><?php echo e($product->name); ?></td>
                    <td><?php echo render_price($cart->price); ?></td>
                    <td>
                        <div><?php echo e($product->unit); ?></div>
                        <?php if($cart->options->count()): ?>
                            <?php $__currentLoopData = $cart->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupAttr => $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($variable_group[$groupAttr]); ?>: <?php echo e(render_option_name($variable)); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($cart->qty); ?></td>
                    <td style="white-space: nowrap;"><?php echo render_price($cart->price * $cart->qty); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="font-weight-600">
                <tr>
                    <td colspan="4" class="text-right">Thành tiền</td>
                    <td class="cart_total" style="white-space: nowrap;"><?php echo render_price(Cart::total(2)); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/includes/checkout_cart_item.blade.php ENDPATH**/ ?>