<?php
    $payment_method = $payment_method ?? $cart_info['payment_method']??'';
?>
<hr>
    <div class="your-payment">
        <h4 class="order-title my-4">Phương thức thanh toán</h4>
        <div class="d-flex align-items-center mb-3">
            <div class="custom-control custom-radio mr-2">
                <input type="radio" id="payment_paypal" name="payment_method" value="cash" class="custom-control-input" <?php echo e($payment_method == '' ? 'checked' : ''); ?> <?php echo e($payment_method == 'cash' ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="payment_paypal">Thanh toán Tiền mặt</label>


            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="custom-control custom-radio mr-2 w-100">
                <input type="radio" id="payment_credit_card" name="payment_method" value="bank_transfer" class="custom-control-input"  <?php echo e($payment_method == 'bank_transfer' ? 'checked' : ''); ?>>
                <label class="custom-control-label" for="payment_credit_card">Thanh toán Chuyển khoản</label>
                <div class="payment-content p-3 border rounded mt-2"  <?php echo $payment_method == 'bank_transfer' ? '' : 'style="display: none;"'; ?> >
                    <?php echo htmlspecialchars_decode(setting_option('banks')); ?>

                </div>
            </div>
        </div>
        <div class="payment-method">                                    
            <div class="order-button-payment"></div>
        </div>
    </div><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/includes/payment-method.blade.php ENDPATH**/ ?>