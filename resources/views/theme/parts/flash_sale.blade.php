@if(isset($flash_sale) && $flash_sale->count())
<!-- Discounted products (Carousel)-->
<section class="flash_sale_container p-2 pe-0 mb-3">
    <!-- Heading-->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 px-3 pt-2">
        <h2 class="h3 mb-0 me-3 text-white flash-sale-title">
        	<img class="me-3" src="{{ asset($templateFile .'/images/flash-sale-icon.png') }}" width="31"> Flash SALE
        </h2>
        <div class="pe-3"><a class="view-more text-uppercase" href="#">Xem tất cả <i class="fa fa-long-arrow-right"></i></a></div>
    </div>
    <div class="tns-carousel pb-4 pt-2 ps-3">
        <div class="flash-sale-carousel owl-carousel owl-theme">
            @foreach($flash_sale as $product)
            	@include($templatePath .'.product.product-item', compact('product'))
            @endforeach
            
        </div>
    </div>
</section>
@endisset