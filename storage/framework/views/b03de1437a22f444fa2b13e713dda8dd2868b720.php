<div class="group_item_theme">
	<div class="icon_change_postion"><i class="fa fa-sort"></i></div>
	<div class="left_item_theme left_genate"><input type="text" value="<?php echo e($code_name ?? ''); ?>" placeholder="Please enter Name Field"  name="header_option[img][name][]" /></div>
	<div class="right_item_theme right_genate">
		<div class="input-group">
			<div class="input-group">
				<input type="text" class="form-control input_image <?php echo e($id ?? 'img'); ?>_view" name="header_option[img][value][]" id="<?php echo e($name ?? 'image'); ?>" value="<?php echo e($image ?? ''); ?>" autocomplete="off">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary ckfinder-popup" type="button" id="<?php echo e($id ?? 'img'); ?>"  data-show="<?php echo e($id ?? 'img'); ?>_view" data="<?php echo e($name ?? 'image'); ?>">Upload</button>
				</div>
			</div>
		</div>
	</div>
	<div class="action">
		<input type="button" class="button button-secondary tbl_button_delete_clean" value="Delete" name="delete_tbl"></div>
</div><?php /**PATH /home/admin/domains/exproweb.com/public_html/nhathuockhanhkhoi/resources/views/admin/partials/image-inline.blade.php ENDPATH**/ ?>