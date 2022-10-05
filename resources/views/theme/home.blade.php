@php
    $category_product = Menu::getByName('Categories-product-home') ;
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')

<div class="main_content clear">
 <div class="body-container clear">
   
   @include($templatePath .'.parts.home-slider')

   <!-- Banners-->
   <section class="container pt-4">
     <div class="row">
       <div class="col-md-6 mb-4">
         <div class="banner-item" style="background-image: url({{ asset('/upload/images/banner-bg-1.png')  }}); background-repeat: no-repeat;">
           <div class="py-md-4 my-2 px-md-4 text-center">
             <div class="py-1">
               <h5 class="mb-3">Bạn cần dược sĩ tư vấn ngay?</h5>
               <a class="btn btn-danger btn-radius btn-active btn-sm mb-lg-0 mb-2" href="tel:{{ setting_option('hotline') }}">Hotline {{ setting_option('hotline') }} (miễn phí)</a>
               <a class="btn btn-info btn-radius btn-bold btn-sm mb-lg-0 mb-2" href="https://zalo.me/{{ setting_option('phone') }}" target="_blank">Nhắn tin</a>
             </div>
           </div>
         </div>
       </div>
       <div class="col-md-6 mb-4">
         <div class="banner-item" style="background-image: url({{ asset('/upload/images/banner-bg-2.png')  }}); background-repeat:no-repeat;">
           <div class="py-md-4 my-2 px-md-4 text-center">
             <div class="py-1">
               <h5 class="mb-3">Bạn có toa thuốc của bác sĩ?</h5>
               <a class="btn btn-primary btn-active btn-radius btn-sm" href="javascript:;" data-bs-toggle="modal" data-bs-target="#sendContact">Gửi hình toa thuốc</a>
             </div>
           </div>
         </div>
       </div>
     </div>
      <!-- Modal markup -->
      <div class="modal fade" tabindex="-1" role="dialog" id="sendContact">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Gửi toa thuốc</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form method="POST" action="{{url('contact.html')}}" id="contactForm" enctype="multipart/form-data">
                  @csrf
                  @include($templatePath .'.contact.contact_content')
                  <div class="error-message" style="display: none;"></div>
                  <div class="text-center">
                          <button type="button" class="btn btn-primary btn-send-contact">Gửi toa thuốc</button>
                      </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section id="categories">
      <div class="container">
         @if($categories)
            <div class="categories-list categories-list-custom row">
               @foreach($categories as $category)
                  <div class="col-md-4">
                  @include($templatePath . '.categories-home', compact('category'))
                  </div>
               @endforeach
            </div>
         @endif
      </div>
   </section>

   <!-- flash sale -->
   <section id="flash_sale">
      <div class="container">
         @include($templatePath .'.parts.flash_sale')
      </div>
   </section>

   @if(isset($category_product[0]) && count($category_product[0]))
      @php $category_item = $category_product[0]; @endphp
      @include($templatePath .'.category-product-home', ['category_menu' => $category_item ,'alias' => $category_item['link']])
   @endif

   <section class="py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>SẢN PHẨM Bán Chạy Nhất</h3>
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

   <!-- banner -->
   @include($templatePath .'.layouts.banner_home')

   @if($category_product)
      @foreach($category_product as $key => $category_item)
         @if($key > 0)
            @if($key %2 == 0)
            @php $bg = 'bg-gray'; @endphp
            @endif
            @include($templatePath .'.category-product-home', ['category_menu' => $category_item ,'alias' => $category_item['link'], 'bg'=>$bg??''])
         @endif
      @endforeach
   @endif

   {{--
   <section class="py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>Dành Cho đối tượng đặc biệt</h3>
            <div class="ms-auto d-none d-lg-block">
               <a class="btn btn-outline-secondary btn-radius btn-active ms-1" href="nft-catalog-v1.html">Trẻ em</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Người cao tuổi</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Phụ nữ cho con bú</a>
               <a class="btn btn-outline-secondary btn-radius ms-1" href="nft-catalog-v1.html">Người suy gan, thận</a>
            </div>
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
   <section class="bg-gray py-lg-5 py-3">
      <div class="container py-2">
         <div class="section-title mb-lg-5 mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>sản phẩm hot theo mùa</h3>
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
   --}}

   

   <section id="hot_news" class="py-5">
      <div class="container">
         <div class="section-title mb-lg-5 mb-3 w-100 text-center d-block">
            <h3 class="m-auto mb-3">THÔNG TIN SỨC KHOẺ</h3>
            <p>We help the world’s leading organizations follow their shipping</p>
         </div>
         <div class="row">
            @if($news)
               @php
               $bigPost = $news->first();
               @endphp
               <div class="col-md-6">
                    @if($bigPost)
                    <div class="post">
                        <a class="img" href="{{ route('news.single', [$bigPost->slug, $bigPost->id]) }}" title="">
                            <img src="{{ asset($bigPost->image) }}" alt="" title="">
                        </a>
                        <div class="post-caption pt-3">
                            <h3 class="title"><a class="smooth" href="{{ route('news.single', [$bigPost->slug, $bigPost->id]) }}" title="">{{ $bigPost->name }}</a></h3>
                            <div class="meta">
                                <p class="date d-flex align-items-center">
                                    <i class="ci-time me-2"></i>
                                    {{ Carbon\Carbon::parse($bigPost->created_at)->diffForHumans()}}
                                </p>
                                <a href="" class="btn btn-radius btn-sm">{{ $bigPost->category->first()->name }}</a>
                            </div>
                        </div>

                    </div>
                    @endif
               </div>
               <div class="col-md-6">
                  @foreach($news as $post)
                     @if($post->id != $bigPost->id)
                        <div class="post post-small mb-3">
                            <div class="img">
                                <a class="" href="{{ route('news.single', [$post->slug, $post->id]) }}">
                                    <img src="{{ asset($post->image) }}" alt="">
                                </a>
                            </div>
                            <div class="post-caption">
                                <h3 class="title"><a class="smooth" href="{{ route('news.single', [$post->slug, $post->id]) }}" title="">{{ $post->name }}</a></h3>
                                <div class="meta">
                                    <p class="date d-flex align-items-center">
                                       <i class="ci-time me-2"></i>
                                        {{ Carbon\Carbon::parse($post->created_at)->diffForHumans()}}
                                    </p>
                                </div>
                                <a href="" class="btn btn-radius btn-sm">{{ $post->category->first()->name }}</a>
                            </div>
                        </div>
                     @endif
                 @endforeach
             </div>
            @endif
         </div>
      </div>
   </section>

   <section class="py-lg-5 py-3 bg-green">
      <div class="container py-2">
         <div class="section-title mb-3">
            <img src="{{ asset('img/title-icon.png') }}">
            <h3>Tìm Kiếm Hàng Đầu</h3>
         </div>

         <div class="tag-list">
            <a class="btn btn-radius" href="#">Panadol</a>
            <a class="btn btn-radius" href="#">Khẩu trang</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Nước muối</a>
            <a class="btn btn-radius" href="#">Thuốc ho, sổ mũi</a>
            <a class="btn btn-radius" href="#">Thuốc bổ phổi</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Nước muối</a>
            <a class="btn btn-radius" href="#">Thực phẩm chức năng</a>
            <a class="btn btn-radius" href="#">Panadol</a>
         </div>
      </div>
   </section>

   <section class=" py-lg-5 py-3">
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

 </div><!--body-container-->
</div><!--main_content-->

@endsection
