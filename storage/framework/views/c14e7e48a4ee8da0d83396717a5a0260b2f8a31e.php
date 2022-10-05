<ul class="list-group mb-3">
    <li class="list-group-item">
        <div class="custom-control custom-radio">
            <input type="radio" id="delivery_ship" name="delivery" value="shipping" class="custom-control-input" checked>
            <label class="custom-control-label" for="delivery_ship">Giao hàng nhanh</label>
            <div class="ship-content" style="display: none;">
                - Giá ship thay đổi tùy thời điểm, nhân viên sẽ liên hệ với quý khách để xác nhận.
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="custom-control custom-radio">
            <input type="radio" id="delivery_pickup" name="delivery" value="pick_up" class="custom-control-input">
            <label class="custom-control-label" for="delivery_pickup"><?php echo app('translator')->get('Pick up'); ?></label>
        </div>
    </li>
</ul>

<div class="create-ac-content bg-light-gray padding-20px-all">
    <?php echo $__env->make($templatePath .'.cart.includes.customer-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="msg-error mb-3" style="display: none;"></div>
    <div class="cart-btn">
        <!-- <button type="button" class="btn btn-info get_shipping_usps" title="Continue to shipping">Continue to shipping</button> -->
        <button class="btn btn-primary d-block w-100 mt-3  submit-confirm" value="Place order" type="button" >Xác nhận đơn hàng</button>
    </div>
</div><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/includes/cart-shipping.blade.php ENDPATH**/ ?>