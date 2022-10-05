
<?php
    $variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
?>
<?php $__env->startSection('content'); ?>
        <div class="carts-content">
            <?php echo $__env->make($templatePath . '.cart.cart-list', compact('carts'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('after-footer'); ?>
<script>
    $(document).on('click', '.cart__remove', function(event) {
    event.preventDefault();
    $(this).closest('.cart__row_item').remove();
    var rowId = $(this).attr('data');
    axios({
      method: 'post',
      url: '/cart/ajax/remove',
      data: { rowId:rowId }
    }).then(res => {
        if(res.data.error ==0)
        {
          setTimeout(function () {
            $('#CartCount').html(res.data.count_cart);
            $('#header-cart .total .money').html(res.data.total);
          }, 1000);
          alertJs('success', res.data.msg);
        }else{
          alertJs('error', res.data.msg);
        }
    }).catch(e => console.log(e));
  });

    $(document).on('change', '#quantity1', function(){
        var qty = $('.cart__qty-input').val(),
            rowId = $('.cart__qty-input').data('rowid');
        /*if(qty == 1){
            $('.qtyBtn.minus').addClass('disabled');
        }
        else
            $('.qtyBtn.minus').removeClass('disabled');
        if($('.qtyBtn.minus').hasClass('disabled')){
            return;
        }*/
        if(qty > 0){
            axios({
              method: 'post',
              url: '<?php echo e(route('carts.update')); ?>',
              data: { rowId:rowId, qty: qty }
            }).then(res => {
                if(res.data.error ==0)
                {
                    $('.carts-content').html(res.data.view);
                    setTimeout(function () {
                        $('#CartCount').html(res.data.count_cart);
                        $('.site-cart #header-cart').remove();
                        $('.site-cart').append(res.data.view_cart_mini);
                    }, 1000);
                  alertJs('success', res.data.msg);
                }else{
                  alertJs('error', res.data.msg);
                }
            }).catch(e => console.log(e));
        }
    })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/cart.blade.php ENDPATH**/ ?>