@php
   $alias = $alias??'';
@endphp
@if($alias != '')
   @php
      $alias = str_replace('.html', '', $alias);
      $category_item = ( new \App\ProductCategory )->getDetail($alias, $type='slug');
      if($category_item)
         $category_products = $category_item->products()->limit(10)->get();
   @endphp
   @if($category_item && $category_products->count())
   <section class="py-lg-5 py-3 {{ $bg??'bg-green' }} {{ $alias }}">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>{{ $category_menu['label']??'' }}</h3>
            @if(isset($category_menu['child']) && $category_menu['child'])
            <div class="ms-auto d-none d-lg-block">
               @foreach($category_menu['child'] as $category_child)
               <a class="btn btn-outline-secondary btn-radius ms-1" href="{{ url($category_child['link']) }}">{{ $category_child['label'] }}</a>
               @endforeach
            </div>
            @endif
         </div>

         
            <div class="product-list product-list-5 row">
               @foreach($category_products as $product)
                  <div class="col-custom col-6 mb-3">
                  @include($templatePath .'.product.product-item', compact('product'))
                  </div>
               @endforeach
            </div>
         
      </div>
   </section>
   @endif
@endif