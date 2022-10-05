@extends($templatePath .'.layouts.index')

@section('content')
<section class="container pt-grid-gutter mb-3">
    <div class="category-card d-flex flex-wrap justify-content-md-between">
        @foreach($categories_list as $item)
        <div class="card-item">
            <a class="h-100" href="{{ route('shop.detail', $item->slug) }}" data-scroll>
                <div class="p-2 text-center">
                    <!-- <i class="ci-location h3 mt-2 mb-4 text-primary"></i> -->
                    <img class="mb-3" src="{{ asset($templateFile .'/images/flower-icon.png') }}" height="30">
                    <h3 class="card-title mb-2">{{ $item->name }}</h3>
                    <p class="fs-sm text-muted">{{ $item->products()->count() }} sản phẩm</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>

<div class="container">
    <div class="row">
        <aside class="col-lg-3">
            @include($templatePath .'.product.sidebar')
        </aside>



        <section class="col-lg-9">
                <div class="collection-header mt-2 mb-4">
                    <div class="d-flex flex-wrap justify-content-end">
                        <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4">
                            <label class="fs-sm text-nowrap me-2 d-none d-sm-block" for="sorting">SẮP XẾP THEO:</label>
                            <select class="form-select" id="sorting">
                                <option value="id__desc">Mới nhất</option>
                                <option value="id__asc">Cũ nhất</option>
                                <option value="price__asc">Giá tăng dần</option>
                                <option value="price__esc">Giá giảm dần</option>
                                <option value="name__desc">Từ A - Z</option>
                                <option value="name__asc">Từ Z - A</option>
                            </select>
                        </div>
                      </div>
                </div>
                <!--End Collection Banner-->
                    <div class="product-list row">
                       @foreach($products as $product)
                          <div class="col-lg-3 col-6 mb-3">
                          @include($templatePath .'.product.product-item', compact('product'))
                          </div>
                       @endforeach
                    </div>
                <!--Pagination-->
                <hr class="clear">
                <div class="mt-3">
                    {!! $products->links() !!}
                </div>
        </section>
    </div>
</div>

@include($templatePath . '.product.product-viewed')

@endsection
