@php
    //$galleries = $product->getGallery() ?? '';

    $spec_short = $product->spec_short ?? '';
    if($spec_short != '')
        $spec_short = unserialize($spec_short);
@endphp

@extends($templatePath .'.layouts.index')

@section('content')
    <div class="breadcrumb-container">
        <nav class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Trang chủ</a></li>
                @if(isset($brc) && count($brc))
                    @foreach($brc as $item)
                        @if($item['url'])
                        <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['name'] }}</a></li>
                        @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li>
                        @endif
                    @endforeach
                @endif 
            </ol>
        </nav>
    </div>
    
    <div id="page-content" class="template-product">
        <!--MainContent-->
        <div id="MainContent" class="main-content" role="main">
            <div id="ProductSection-product-template" class="product-template__container prstyle3 container-fluid">
                <div class="product-single product-single-1 mt-lg-3">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-single-gallery">
                                    @include($templatePath .'.product.product-gallery')
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                @include($templatePath .'.product.product-summary')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <!--Product Tabs-->
                                <div class="tabs-listing">
                                    <ul class="product-tabs">
                                        <li rel="tab1"><a class="tablink">@lang('Chi tiết sản phẩm')</a></li>
                                        <li rel="tab2"><a class="tablink">@lang('Thông số kỹ thuật')</a></li>
                                    </ul>
                                    <div class="tab-container">
                                        <!--Description tab-->
                                        <div id="tab1" class="tab-content">
                                            <div class="product-description rte max-height-300">
                                                {!! htmlspecialchars_decode($product->content) !!}
                                            </div>
                                            <div class="text-center">
                                                <a href="javascript:;" class="btn btn-primary description-view-more" data-more="@lang('Xem thêm')" data-less="@lang('Thu gọn')">@lang('Xem thêm')</a>
                                            </div>
                                        </div>
                                        <!--End description tab-->

                                        <div id="tab2" class="tab-content">
                                            @if(is_array($spec_short))
                                                  <div class="option_focus">
                                                     <div class="heading-top"><i class="fa fa-plus-circle"></i> @lang('Thông số kỹ thuật')</div>
                                                     <ul class="parametdesc mb-0">
                                                        @foreach($spec_short as $index => $item)
                                                           <li class="item{{ $index }}">
                                                              <span>{{ $item['name'] ?? '' }}</span>
                                                              <strong>{{ $item['desc'] ?? '' }}</strong>
                                                           </li>
                                                        @endforeach
                                                     </ul>
                                                  </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--End Product Tabs-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-footer')
    <script>
        $(function() {
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
@endpush
