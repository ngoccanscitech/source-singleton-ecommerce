@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@php
    $variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
@endphp
@section('content')
        <div class="carts-content">
            @include($templatePath . '.cart.cart-list', compact('carts'))
        </div>

@endsection


@push('after-footer')
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
              url: '{{ route('carts.update') }}',
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
@endpush