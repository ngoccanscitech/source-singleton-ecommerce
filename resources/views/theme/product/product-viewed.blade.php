@php
   $session_products = session()->get('products.recently_viewed');
   $product_viewed = \App\Product::whereIn('id', $session_products)->take(10)->get();
@endphp
<section class=" py-3">
   <div class="container py-2">
      <div class="section-title mb-lg-5 mb-3">
         <img src="{{ asset('img/title-icon.png') }}">
         <h3>Vừa Mới Xem</h3>
      </div>

      @if($product_viewed)
         <div class="product-list product-list-5 row">
            @foreach($product_viewed as $product)
               <div class="col-custom col-6 mb-3">
               @include($templatePath .'.product.product-item', compact('product'))
               </div>
            @endforeach
         </div>
      @endif
   </div>
</section>