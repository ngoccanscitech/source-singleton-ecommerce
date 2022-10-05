@php
    $slug = str_replace('.html', '', $data['link']);
    $category = \App\ProductCategory::where('categorySlug', $slug)->first();
    $category_products = \App\Product::with('categories')->whereHas('categories', function($query) use($slug){
                    return $query->where('categorySlug', $slug);
                })->limit(8)->get();
    $perView = isset($slideNum) && $slideNum > 0 ? $slideNum : 5;
@endphp

@if($category_products->count() > 0)
@php $slideNum = 5 @endphp
<div id="{{ $category->categoryID }}" class="cat-pro-list">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2 font-weight-bold section-title">{{ $title }}</h2>
                </div>
            </div>
        </div>
        <div class="productSlider grid-products" data-perview="{{ $perView }}">
            @foreach ($category_products as $product)
            <div class="col-12 item">
                @include($templatePath .'.product.product-item', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
