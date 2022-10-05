<?php 
    
    //$parent_id = $parent_id ?? 0;
    //$dategories = \App\Model\ShopCategory::where('parent', $parent_id)->orderByDesc('preority')->get();
?>
<?php if(count($categories)>0): ?>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="tr-item item-level-<?php echo e(isset($level) ? $level : 0); ?>">
            <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
            <td class="text-center stt"><?php echo e($data->priority); ?></td>
            <td class="title">
                <a class="row-title " href="<?php echo e(route('admin.categoryProductDetail', array($data->id))); ?>">
                    <div><b style='color: #056FAD;'><?php echo e($data->name); ?></b></div>
                </a>
                <div>
                    <b style='color:#777;'>URL:</b>
                    <a style='color:#00C600; word-break:break-all;' target='_blank' href="<?php echo e(route('shop.detail', ['slug'=>$data->slug])); ?>"><?php echo e(route('shop.detail', ['slug'=>$data->slug])); ?></a>
                </div>

            </td>
            <td class="text-center">
                <?php if($data->image != null): ?>
                    <img src="<?php echo e(asset($data->image)); ?>" style="height: 70px">
                <?php endif; ?>
            </td>
            <td class="text-center">
                <?php echo e($data->updated_at); ?>

                <br>
                <?php echo e($data->status == 1 ? 'Public' : 'Draft'); ?>

            </td>
        </tr>
        <?php if(count($data->children)>0): ?>
            <?php echo $__env->make('admin.product-category.includes.category_item', [
                'categories'=> $data->children, 
                'level'=>$level+1
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/product-category/includes/category_item.blade.php ENDPATH**/ ?>