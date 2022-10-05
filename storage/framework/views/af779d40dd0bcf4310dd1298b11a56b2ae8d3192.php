<div class="card">
    <div class="card-header">
        <h5><?php echo e($title ?? 'Image Thumbnail'); ?></h5>
    </div> <!-- /.card-header -->
    <div class="card-body">
            <div class="input-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="<?php echo e($name ?? 'image'); ?>" id="<?php echo e($name ?? 'image'); ?>" value="<?php echo e($image); ?>">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="<?php echo e($id ?? 'img'); ?>"  data-show="<?php echo e($id ?? 'img'); ?>_view" data="<?php echo e($name ?? 'image'); ?>">Upload</button>
                    </div>
                </div>
            </div>
            <div class="demo-img" style="padding-top: 10px;">
                <?php if($image != ""): ?>
                    <img class="<?php echo e($id ?? 'img'); ?>_view" src="<?php echo e(asset($image)); ?>">
                <?php else: ?>
                    <img class="<?php echo e($id ?? 'img'); ?>_view" src="<?php echo e(asset('assets/images/placeholder.png')); ?>">
                <?php endif; ?>
            </div>
    </div> <!-- /.card-body -->
</div><!-- /.card --><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/partials/image.blade.php ENDPATH**/ ?>