
@if(isset($product))   
   @if (count($product->getGallery()))
      <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">

         @foreach ($product->getGallery() as $key=>$image)
         <div
          class="carousel__slide"
          data-src="{{ asset($image) }}"
          data-fancybox="gallery">
            <img src="{{ asset($image) }}" width="100%" height="100%" />
         </div>
         @endforeach
      </div>

      <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
         @foreach ($product->getGallery() as $key=>$image)
            <div class="carousel__slide">
               <img class="panzoom__content" src="{{ asset($image) }}" width="100%" height="100%" />
            </div>
         @endforeach
      </div>
      {{--

      <div class="product-gallery">
         <div class="product-gallery-preview order-sm-2">
            @foreach ($product->getGallery() as $key=>$image)
            <div class="product-gallery-preview-item active" id="item_{{$key}}"><img class="image-zoom" src="{{ $image }}" data-zoom="{{ $image }}" alt="Product image">
               <div class="image-zoom-pane"></div>
            </div>
            @endforeach
         </div>
         <div class="product-gallery-thumblist order-sm-1">
            @foreach ($product->getGallery() as $key=>$image)
            <a class="product-gallery-thumblist-item active" href="#item_{{$key}}">
               <img src="{{ $image }}" alt="Product thumb">
            </a>
            @endforeach
            
          </div>
      </div>
      --}}
   @else
      <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
         <div
          class="carousel__slide"
          data-src="{{ asset($product->image) }}"
          data-fancybox="gallery">
            <img src="{{ asset($product->image) }}" width="100%" height="100%" alt="" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';">
         </div>
      </div>
   @endif
@endif

@push('head-style')
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
@endpush
@push('after-footer')
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script defer>
   jQuery(document).ready(function($) {
      var mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
              Dots: false,
            });

            // Thumbnails
            var thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
              Sync: {
                target: mainCarousel,
                friction: 0,
              },
              Dots: false,
              Navigation: false,
              center: true,
              slidesPerPage: 1,
              infinite: false,
            });

            // Customize Fancybox
            Fancybox.bind('[data-fancybox="gallery"]', {
              Carousel: {
                on: {
                  change: (that) => {
                    mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                      friction: 0,
                    });
                  },
                },
              },
            });
   });
</script>
@endpush