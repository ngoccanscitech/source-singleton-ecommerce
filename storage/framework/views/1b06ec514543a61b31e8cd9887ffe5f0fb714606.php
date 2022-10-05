<?php
    $image = $gallery ?? '';
    $index = $index ?? 0;
?>
    <div class="group_item_images mb-2">
        <div class="inside d-flex">
            <div class="icon_change_postion"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
            <div class="image-view mr-2">
                <?php if($image): ?>
                    <img class="gallery-view<?php echo e($index); ?>" src="<?php echo e(asset($image)); ?>" style="height: 38px;">
                <?php else: ?>
                    <img class="gallery-view<?php echo e($index); ?>" src="<?php echo e(asset('assets/images/placeholder.png')); ?>" style="height: 38px;">
                <?php endif; ?>
            </div>
            <div class="input-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="gallery[]" id="gallery-input<?php echo e($index); ?>" value="<?php echo e($image); ?>">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="gallery-item<?php echo e($index); ?>"  data-show="gallery-view<?php echo e($index); ?>" data="gallery-input<?php echo e($index); ?>">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!--group_item_images-->
<?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/partials/gallery-item.blade.php ENDPATH**/ ?>