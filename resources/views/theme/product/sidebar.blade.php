@php
  $category_id = $category->id ?? 0;
@endphp
<div class="offcanvas offcanvas-collapse bg-white w-100 rounded-3 py-1" id="shop-sidebar" style="max-width: 22rem;">
  <div class="offcanvas-header align-items-center shadow-sm">
    <h2 class="h5 mb-0">Filters</h2>
    <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <!-- Categories-->
    <div class="widget widget-categories mb-4 ">
      <h3 class="widget-title d-flex align-items-center">
        <img class="me-4 ms-3" src="{{ asset($templateFile .'/images/filter-icon.png') }}" height="12"> Danh mục
      </h3>
      <div class="accordion mt-n1" id="shop-categories">
        @foreach($categories_list as $category_item)
        <div class="accordion-item">
          <h3 class="accordion-header">
            @if($category_item->children()->count())
              <a class="accordion-button collapsed {{ $category_item->id == $category_id ? 'active' : '' }}" href="#{{ $category_item->slug }}" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="{{ $category_item->slug }}">{{ $category_item->name }}</a>
            @else
             <a class="accordion-button collapsed {{ $category_item->id == $category_id ? 'active' : '' }}" href="{{ route('shop.detail', $category_item->slug) }}">{{ $category_item->name }}</a>
            @endif
         </h3>
         <div class="accordion-collapse collapse" id="{{ $category_item->slug }}" data-bs-parent="#shop-categories">
           <div class="accordion-body">
             <div class="widget widget-links widget-filter">
               <ul class="widget-list widget-filter-list pt-1">
                  <li class="widget-list-item widget-filter-item">
                     <a class="widget-list-link d-flex justify-content-between align-items-center {{ $category_item->id == $category_id ? 'active' : '' }}" href="{{ route('shop.detail', $category_item->slug) }}">
                        <span class="widget-filter-item-text">Xem tất cả</span>
                     </a>
                  </li>
                  @foreach($category_item->children as $item)
                  <li class="widget-list-item widget-filter-item">
                     <a class="widget-list-link d-flex justify-content-between align-items-center {{ $item->id == $category_id ? 'active' : '' }}" href="{{ route('shop.detail', $item->slug) }}">
                        <span class="widget-filter-item-text">{{ $item->name }}</span>
                     </a>
                  </li>
                  @endforeach
               </ul>
             </div>
           </div>
         </div>
         
          
        </div>
        @endforeach
        
      </div>

    </div>
      
      {{--
      <!-- Filter by Brand-->
      <div class="widget widget-filter mb-4 " style="display:none;">
        <h3 class="widget-title d-flex align-items-center"><img class="me-4 ms-3" src="{{ asset($templateFile .'/images/filter-icon.png') }}" height="12"> Bộ lọc mỹ phẩm</h3>
        <div class="accordion mt-n1" id="shop-filter">
          <!-- Shoes-->
          <div class="accordion-item mb-2">
            <h3 class="accordion-header"><a class="accordion-button collapsed" href="#brand" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="brand">Hãng Sản Xuất</a></h3>
            <div class="accordion-collapse collapse" id="brand" data-bs-parent="#shop-filter">
              <div class="accordion-body">
                <div class="widget widget-links widget-filter">
                  <!-- <div class="input-group input-group-sm mb-2">
                    <input class="widget-filter-search form-control rounded-end" type="text" placeholder="Search"><i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                  </div> -->
                  <ul class="widget-list widget-filter-list pt-1" style="height: 12rem;" data-simplebar data-simplebar-auto-hide="false">
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">View all</span><span class="fs-xs text-muted ms-3">1,953</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Pumps &amp; High Heels</span><span class="fs-xs text-muted ms-3">247</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Ballerinas &amp; Flats</span><span class="fs-xs text-muted ms-3">156</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Sandals</span><span class="fs-xs text-muted ms-3">310</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Sneakers</span><span class="fs-xs text-muted ms-3">402</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Boots</span><span class="fs-xs text-muted ms-3">393</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Ankle Boots</span><span class="fs-xs text-muted ms-3">50</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Loafers</span><span class="fs-xs text-muted ms-3">93</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Slip-on</span><span class="fs-xs text-muted ms-3">122</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Flip Flops</span><span class="fs-xs text-muted ms-3">116</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Clogs &amp; Mules</span><span class="fs-xs text-muted ms-3">24</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Athletic Shoes</span><span class="fs-xs text-muted ms-3">31</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Oxfords</span><span class="fs-xs text-muted ms-3">9</span></a></li>
                    <li class="widget-list-item widget-filter-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="#"><span class="widget-filter-item-text">Smart Shoes</span><span class="fs-xs text-muted ms-3">18</span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- Clothing-->
          <div class="accordion-item mb-2">
            <h3 class="accordion-header"><a class="accordion-button" href="#trademark" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="trademark">Thương hiệu</a></h3>
            <div class="accordion-collapse collapse show" id="trademark" data-bs-parent="#shop-filter">
              <div class="accordion-body">
                <div class="widget widget-links widget-filter">
                  <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="adidas">
                        <label class="form-check-label widget-filter-item-text" for="adidas">Adidas</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ataylor">
                        <label class="form-check-label widget-filter-item-text" for="ataylor">Ann Taylor</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="armani">
                        <label class="form-check-label widget-filter-item-text" for="armani">Armani</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="banana">
                        <label class="form-check-label widget-filter-item-text" for="banana">Banana Republic</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="bilabong">
                        <label class="form-check-label widget-filter-item-text" for="bilabong">Bilabong</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="birkenstock">
                        <label class="form-check-label widget-filter-item-text" for="birkenstock">Birkenstock</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="klein">
                        <label class="form-check-label widget-filter-item-text" for="klein">Calvin Klein</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="columbia">
                        <label class="form-check-label widget-filter-item-text" for="columbia">Columbia</label>
                      </div>
                    </li>
                    <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="converse">
                        <label class="form-check-label widget-filter-item-text" for="converse">Converse</label>
                      </div>
                    </li>
                  </ul>

                </div>
              </div>
            </div>
          </div>
          <!-- price-->
          <div class="accordion-item">
            <h3 class="accordion-header"><a class="accordion-button" href="#trademark" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="trademark">Giá bán</a></h3>
            <div class="accordion-collapse collapse show" id="trademark" data-bs-parent="#shop-filter">
              <div class="accordion-body bg-unset">
                <div class="widget widget-links widget-price">
                  <a class="btn btn-outline-secondary btn-radius mb-2 href="#">Dưới 100.000đ</a>
                  <a class="btn btn-outline-secondary btn-radius mb-2" href="#">100.000đ đến 300.000đ</a>
                  <a class="btn btn-outline-secondary btn-radius mb-2" href="#">300.000đ đến 500.000đ</a>
                  <a class="btn btn-outline-secondary btn-radius mb-2" href="#">500.000đ đến 900.000đ</a>
                  <a class="btn btn-outline-secondary btn-radius mb-2" href="#">Trên 1 triệu</a>

                  <div class="mb-2">Chọn khoảng giá</div>
                  <div class="d-flex align-items-center pb-1">
                      <div class="w-50 pe-2 me-2">
                        <div class="input-group input-group-sm">
                          <input class="form-control range-slider-value-min" type="text" placeholder="Từ">
                        </div>
                      </div>
                      <span style="padding-right: 8px"> - </span>
                      <div class="w-50 ps-2">
                        <div class="input-group input-group-sm">
                          <input class="form-control range-slider-value-max" type="text" placeholder="Đến">
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        
      </div>
      --}}
      
    </div>

</div>