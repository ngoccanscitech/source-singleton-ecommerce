<div class="category-item">
    <a href="{{ route('shop.detail', $category->slug) }}" title="{{ $category->name }}">
        <div class="image">
            <div class="image-item">
                @if($category->image != '')
                <img class="rounded-3" src="{{ asset($category->image) }}" alt="{{ $category->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';">
                @else
                <img class="rounded-3" src="{{ asset('assets/images/no-image.jpg') }}" alt="{{ $category->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';">
                @endif
            </div>
        </div>
        <div class="category-content p-3 text-center">
            <h3 class="h6 blog-entry-title mb-2">{{ $category->name }}</h3>
            @if($category->products()->count())
            <p>{{ $category->products()->count() }} sản phẩm</p>
            @endif
        </div>
    </a>
</div>