<!--Post Gallery-->
<div class="form-group">
    <label>Post Gallery</label>
    <div class="content_gallery_list_images">
        <div class="content_add_item_images ">
            <?php if(empty($gallery_images)): ?>
                <?php echo $__env->make('admin.partials.gallery-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php $__currentLoopData = $gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $gallery = !empty($gallery) ? $gallery : '';
                    ?>
                    <?php echo $__env->make('admin.partials.gallery-item', compact('index', 'gallery'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div><!--content_add_item_images-->
        <div class="clear add_link  text-right">
            <button type="button" class="btn btn-primary add_part_images">+ Add Image</button>
        </div>
    </div>

    <div class="include-item" style="display: none;">
        <?php echo $__env->make('admin.partials.gallery-item', ['gallery'=>''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<!--End Post Gallery-->
<?php $__env->startPush('scripts-footer'); ?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).on('click', '.add_part_images', function() {
            var index = $(this).closest('.content_gallery_list_images').find('.content_add_item_images').find('.group_item_images').length + 1;
            var gallery_item = $('.include-item').find('.group_item_images').clone();
            var id = gallery_item.find('input').attr('id'),
                btn_id = gallery_item.find('button').attr('id'),
                data_input = gallery_item.find('button').attr('data');
                data_show = gallery_item.find('button').data('show');
            gallery_item.find('img').attr('src', "<?php echo e(asset('assets/images/placeholder.png')); ?>");
            gallery_item.find('img').attr('class', data_show+index);
            gallery_item.find('button').data('show', data_show+index);
            gallery_item.find('input').val('');
            gallery_item.find('input').attr('id', id+index);
            gallery_item.find('button').attr('id', btn_id+index);
            gallery_item.find('button').attr('data', data_input+index);
            // console.log(gallery_item);
            $(this).closest('.content_gallery_list_images').find('.content_add_item_images').append(gallery_item);
            $(this).parent().parent().parent().find(".gallery_item_txt").val(index);

            $(document).on('click', '.ckfinder-popup', function(){
                var id = $(this).attr('id'),
                    input = $(this).attr('data'),
                    view_img = $(this).data('show');
                selectFileWithCKFinder( input, view_img );
            })

            /*$('.ckfinder-popup').each(function(index, el) {
                var id = $(this).attr('id'),
                    input = $(this).attr('data'),
                    view_img = $(this).data('show');
                var button1 = document.getElementById( id );
                $(document).on('click', '#'+ id, function() {
                    selectFileWithCKFinder( input, view_img );
                });
            });*/
        });

        $(".content_add_item_images").sortable({
            stop: function(event, ui){
                var cnt = 1;
                $(this).children('.group_item_images').each(function(){
                    $(this).find('input.myfile_gallery_store').attr('name','upload_gallery'+cnt);
                    //.val(cnt);
                    cnt++;
                });
            }
        });

    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/partials/galleries.blade.php ENDPATH**/ ?>