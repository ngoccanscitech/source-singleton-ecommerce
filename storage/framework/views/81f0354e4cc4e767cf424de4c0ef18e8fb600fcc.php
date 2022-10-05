<?php if($priceFinal > 0): ?>
    <?php
    $price_sale = $price - $priceFinal;
    $price_percent = round($price_sale * 100 / $price);
    ?>
    
    
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money"><?php echo render_price($priceFinal); ?></span></span>
        <?php if(isset($unit) && $unit != ''): ?>
        <span>/ <?php echo $unit; ?></span>
        <?php endif; ?>
    </span>

    <s id="ComparePrice-product-template"><span class="money"><?php echo render_price($price); ?></span></s>

    <div class="product-sale">Sale<br><span><?php echo e($price_percent); ?>%</span></div>

    
<?php else: ?>
    <?php if($price > 0): ?>
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money"><?php echo render_price($price); ?></span></span>
    </span>
    <?php else: ?>
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money">Liên hệ</span></span>
    </span>
    <?php endif; ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/product/includes/showPriceDetail.blade.php ENDPATH**/ ?>