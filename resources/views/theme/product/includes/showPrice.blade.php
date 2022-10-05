<div class="product-price">
	@if($priceFinal > 0)
    <span class="old-price">{{ render_price($price) }}</span>
    <span class="price">{{ render_price($priceFinal) }}</span>
    @else
    <span class="price">{{ render_price($price) }}</span>
    @endif
</div>