@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<section class="container pt-grid-gutter mb-3">
    <div class="category-card d-flex flex-wrap justify-content-md-between">
        @foreach($categories_list as $item)
        <div class="card-item {{ $category->id == $item->id ? 'active' : '' }}">
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
                <form action="" method="get">
                    <div class="collection-header mt-2 mb-4">
                        <div class="d-flex flex-wrap justify-content-end">
                            <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4">
                                <label class="fs-sm text-nowrap me-2 d-none d-sm-block" for="sorting">SẮP XẾP THEO:</label>
                                <select class="form-select" id="sorting" name="sort" onchange="this.form.submit()">
                                    <option value="id__desc" {{ request('sort') == 'id__desc' ? 'selected' : '' }}>Mới nhất</option>
                                    <option value="id__asc" {{ request('sort') == 'id__asc' ? 'selected' : '' }}>Cũ nhất</option>
                                    <option value="price__asc" {{ request('sort') == 'price__asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                    <option value="price__desc" {{ request('sort') == 'price__desc' ? 'selected' : '' }}>Giá giảm dần</option>
                                    <option value="name__desc" {{ request('sort') == 'name__desc' ? 'selected' : '' }}>Từ A - Z</option>
                                    <option value="name__asc" {{ request('sort') == 'name__asc' ? 'selected' : '' }}>Từ Z - A</option>
                                </select>
                            </div>
                          </div>
                    </div>
                </form>
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
                {!! $products->withQueryString()->links() !!}
        </section>
    </div>
</div>

<section class=" py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>Vừa Mới Xem</h3>
         </div>

         @if($products)
            <div class="product-list product-list-5 row">
               @foreach($products as $product)
                  <div class="col-custom col-6 mb-3">
                  @include($templatePath .'.product.product-item', compact('product'))
                  </div>
               @endforeach
            </div>
         @endif
      </div>
   </section>
@endsection
