@php
    if($data)
        extract($data);

    $galleries = $product->getGallery() ?? '';
@endphp
<!--Quick View popup-->
<div class="modal fade quick-view-popup" id="content_quickview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="ProductSection-product-template" class="product-template__container prstyle1">
    <div class="product-single">
        <!-- Start model close -->
        <a href="javascript:void()" data-dismiss="modal" class="model-close-btn pull-right" title="close"><span class="icon icon anm anm-times-l"></span></a>
        <!-- End model close -->
        <!--product-single-->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                @include('americannail.product.product-gallery', compact('galleries','product'))
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                @include('americannail.product.product-summary')
            </div>
        </div>
        <!--End-product-single-->
    </div>
</div>

            </div>
        </div>
    </div>
</div>
<!--End Quick View popup-->

    <script src="{{ url('americannail/js/vendor/photoswipe.min.js') }}"></script>
    <script src="{{ url('americannail/js/vendor/photoswipe-ui-default.min.js') }}"></script>
    <script>
        $(function() {
            var $pswp = $('.pswp')[0],
                image = [],
                getItems = function() {
                    var items = [];
                    $('.lightboximages a').each(function() {
                        var $href = $(this).attr('href'),
                            $size = $(this).data('size').split('x'),
                            item = {
                                src: $href,
                                w: $size[0],
                                h: $size[1]
                            }
                        items.push(item);
                    });
                    return items;
                }
            var items = getItems();

            $.each(items, function(index, value) {
                image[index] = new Image();
                image[index].src = value['src'];
            });
            $('.prlightbox').on('click', function(event) {
                event.preventDefault();

                var $index = $(".active-thumb").parent().attr('data-slick-index');
                $index++;
                $index = $index - 1;

                var options = {
                    index: $index,
                    bgOpacity: 0.9,
                    showHideOpacity: true
                }
                var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
                lightBox.init();
            });

            $(document).on('change', '.product-form__item_color input', function(event) {
                event.preventDefault();
                /* Act on the event */
                var attr_id = $(this).data('id'),
                    product = {{ $product->id }};
                axios({
                  method: 'post',
                  url: '{{ route('ajax.attr.change') }}',
                  data: {attr_id:attr_id, product:product, type:$(this).data('type')}
                }).then(res => {
                  if(res.data.error == 0){
                    $('.product-single-variations').html(res.data.view);
                  }
                }).catch(e => console.log(e));
            });

            $(document).on('change', '.available-item input', function(event) {
                event.preventDefault();

                var attr_id_change = $(this).data('id'),
                    attr_id_change_parent = $(this).data('parent');
                console.log(attr_id_change);
                $('#product_form_addCart').find('input[name="attr_id"]').attr('name', 'attr_id['+ attr_id_change_parent +']').val(attr_id_change);

                var form = document.getElementById('product_form_addCart');
                var formData = new FormData(form);
                
                axios({
                  method: 'post',
                  url: '{{ route('ajax.attr.change') }}',
                  data: formData
                }).then(res => {
                  if(res.data.error == 0){
                    $('.product-single-variations').html(res.data.view);
                    if(res.data.show_price != '')
                        $('.product-single__price').html(res.data.show_price);
                  }
                }).catch(e => console.log(e));
            });
            
        });
    </script>
