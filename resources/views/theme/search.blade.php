@extends($templatePath .'.layouts.index')


@section('seo')
    <title>Search</title>
@endsection
@section('content')

    <section class="space-ptb bg-light ">
        <div class="container">
            <div class="row align-items-center justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <div class="section-title mb-0 mt-4">
                        <h3 class="d-inline">Tìm kiếm</h3>
                    </div>
                </div>
            </div>
            <div class="mb-3">
               Tìm kiếm với từ khóa: <b>"{{ $keyword??'' }}"</b>
            </div>

            <div class="grid-products grid--view-items">
                <div class="row">
                    @isset($products)
                        @foreach ($products as $product)
                        <div class="col-6 col-sm-6 col-md-3 item">
                            @include($templatePath .'.product.product-item', compact('product'))
                        </div>
                        @endforeach
                    @endisset
                </div>
            </div>

            @if($products->count())
            <div class="row">
                <div class="col-12">
                    <hr class="clear">
                    {!! $products->appends(request()->input())->links() !!}
                </div>
            </div>
            @endif
        </div>
    </section>

    
    @push('after-footer')
    <script src="{{ asset('theme/js/customer.js') }}"></script>
    @endpush
@endsection
