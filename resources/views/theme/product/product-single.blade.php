@php
    //$galleries = $product->getGallery() ?? '';

    $spec_short = $product->spec_short ?? '';
    if($spec_short != '')
        $spec_short = json_decode($spec_short, true);
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<div class="container">
    <div class="product-single mt-lg-3">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12 col-12 mt-lg-0 mt-3">
                <nav aria-label="breadcrumb" class="mb-3 d-md-none">
                  <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="/">Trang chủ</a></li>
                    @if(isset($brc) && count($brc))
                        @foreach($brc as $item)
                            @if($item['url'])
                            <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['name'] }}</a></li>
                            @else
                            <!-- <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li> -->
                            @endif
                        @endforeach
                    @endif 
                  </ol>
                </nav>

                <div class="product-single-gallery">
                    @include($templatePath .'.product.product-gallery')
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 col-12">
                <nav aria-label="breadcrumb" class="mb-3 d-md-block d-none">
                  <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="/">Trang chủ</a></li>
                    @if(isset($brc) && count($brc))
                        @foreach($brc as $item)
                            @if($item['url'])
                            <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['name'] }}</a></li>
                            @else
                            <!-- <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li> -->
                            @endif
                        @endforeach
                    @endif 
                  </ol>
                </nav>
                @include($templatePath .'.product.product-summary')
            </div>
        </div>
        <div class="row">
            <div class="col-12 pb-5 mt-4">
                <!--Product Tabs-->
                <div class="tabs-listing">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link py-4 px-sm-4 active" href="#general" data-bs-toggle="tab" role="tab" aria-selected="false"><span>Chi tiết sản phẩm</span></a></li>
                        <li class="nav-item"><a class="nav-link py-4 px-sm-4" href="#specs" data-bs-toggle="tab" role="tab" aria-selected="true">Thành phần</a></li>
                    </ul>

                    <div class="tab-content px-lg-3">
                        <div class="tab-pane fade active show" id="general" role="tabpanel">
                            {!! htmlspecialchars_decode($product->content) !!}
                        </div>
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            @if(is_array($spec_short))
                                  <div class="option_focus">
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

    <section class=" py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>SẢN PHẨM LIÊN QUAN</h3>
         </div>

         @if($related)
            <div class="product-list product-list-5 row">
               @foreach($related as $product)
                  <div class="col-custom col-6 mb-3">
                  @include($templatePath .'.product.product-item', compact('product'))
                  </div>
               @endforeach
            </div>
         @endif
      </div>
   </section>
   @if($product_viewed)
   <section class=" py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>Vừa Mới Xem</h3>
         </div>

        
            <div class="product-list product-list-5 row">
                @foreach($product_viewed as $key => $product)
                    @if($key<5)
                    <div class="col-custom col-6 mb-3">
                    @include($templatePath .'.product.product-item', compact('product'))
                    </div>
                    @endif
               @endforeach
            </div>
         
      </div>
   </section>
   @endif
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
