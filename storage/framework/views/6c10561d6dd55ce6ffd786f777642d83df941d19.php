<div class="product-single__meta mt-lg-0 mt-3">
    <h1 class="product-single__title"><?php echo e($product->name); ?></h1>
    <!-- <div class="product-nav clearfix">
        <a href="#" class="next" title="Next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </div> -->
    <div class="prInfoRow mb-3 d-flex flex-wrap">
        <?php if($product->sku): ?>
        <div class="product-sku me-2">SKU: <span class="variant-sku"><?php echo e($product->sku); ?></span></div>
        <?php endif; ?>
        <?php if($brand != ''): ?>
        <div class="product-brand me-2">Thương Hiệu: <span class="variant-sku"><?php echo e($brand); ?></span></div>
        <?php endif; ?>
        <div class="product-brand"><a href="<?php echo e(route('shop')); ?>">Sản phẩm cùng thành phần</a></div>
    </div>

    <div class="product-single__price product-single__price-product-template d-flex align-items-center mb-3">
        <?php echo $product->showPriceDetail(); ?>

    </div>

    <div class="product-single__description rte mb-3">
        <?php echo htmlspecialchars_decode($product->description); ?>

    </div>
    
    <form method="post" action="<?php echo e(route('cart.ajax.add')); ?>" id="product_form_addCart" accept-charset="UTF-8" class="product-form product-form-product-template hidedropdown" enctype="multipart/form-data">
        <input type="hidden" name="product" value="<?php echo e($product->id); ?>">
    <div class="product-form product-form-product-template hidedropdown">
        
        <!-- Product Action -->
        <div class="product-action clearfix">
            <div class="product-form__item--quantity mb-3">
                <div class="wrapQtyBtn d-flex align-items-center">
                    <span class="me-2">Số lượng:</span>
                    <div class="qtyField">
                        <a class="qtyBtn minus" href="javascript:void(0);">-</a>
                        <input type="text" id="Quantity" name="qty" value="1" class="product-form__input qty">
                        <a class="qtyBtn plus" href="javascript:void(0);">+</a>
                    </div>
                </div>
            </div>
            <div class="product-btn-group d-flex w-100">
                <div class="product-form__item--submit">
                    <button type="button" name="add" class="btn product-form__cart-add btn-radius btn-primary w-100">
                        <img src="<?php echo e($templateFile . '/images/cart-white.png'); ?>" height="25">
                        <span>Thêm vào giỏ</span>
                    </button>
                </div>
                <div class="shopify-payment-button">
                    <a href="<?php echo e(route('shop.buyNow', $product->id)); ?>" class="quick-buy btn btn-radius btn-danger ms-3">
                        <img src="<?php echo e($templateFile . '/images/flash-icon.png'); ?>" height="25">
                        MUA NGAY
                    </a>
                </div>
            </div>
        </div>
        <!-- End Product Action -->
        <div class="banner-item mt-3" style="min-height: 150px;background-image: url(<?php echo e(asset('/upload/images/banner-bg-1.png')); ?>); background-repeat: no-repeat;">
           <div class="py-md-4 my-2 px-md-4 text-center">
             <div class="py-1">
               <h5 class="mb-3">Bạn cần dược sĩ tư vấn ngay?</h5>
               <a class="btn btn-danger btn-radius btn-active btn-sm mb-lg-0 mb-2" href="#">Hotline 1800 6928 (miễn phí)</a>
               <a class="btn btn-info btn-radius btn-bold btn-sm mb-lg-0 mb-2" href="#">Nhắn tin</a>
             </div>
           </div>
         </div>
        
    </div>
    </form>

    <div class="display-table shareRow d-none">
        <div class="display-table-cell">
            <div class="social-sharing">
                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-facebook" title="Share on Facebook">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Share</span>
                </a>
                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-twitter" title="Tweet on Twitter">
                    <i class="fa fa-twitter" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Tweet</span>
                </a>
                <a href="#" title="Share on google+" class="btn btn--small btn--secondary btn--share">
                    <i class="fa fa-google-plus" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Google+</span>
                </a>
                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Pin on Pinterest">
                    <i class="fa fa-pinterest" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Pin it</span>
                </a>
                <a href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Share by Email" target="_blank">
                    <i class="fa fa-envelope" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Email</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/product/product-summary.blade.php ENDPATH**/ ?>