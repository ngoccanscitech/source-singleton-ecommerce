<?php
    $segment_check = Request::segment(2); 
    ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
    <img src="{{asset( setting_option('favicon') )}}" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span style="font-size: 0.8rem" class="fw-bold">{!! setting_option('admin-title') !!}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('index')}}" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Homepage</p>
                    </a>
                </li>
                @if(Auth::guard('admin')->user()->admin_level == 99999)
                <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-pages', 'page', 'edit-page'))){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-pages', 'page', 'edit-page'))){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p> Page <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.pages')}}" class="nav-link <?php if(in_array($segment_check, array('list-pages'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.pages') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.createPage')}}" class="nav-link <?php if(in_array($segment_check, array('page'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.page_add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-post', 'post', 'edit-post', 'list-category-post', 'category-post'))){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-post', 'post', 'edit-post', 'list-category-post', 'category-post'))){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>{{ trans('admin.post') }}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.posts')}}" class="nav-link <?php if(in_array($segment_check, array('list-post'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.posts') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.createPost')}}" class="nav-link <?php if(in_array($segment_check, array('post'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.post_add') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.listCategoryPost')}}" class="nav-link <?php if(in_array($segment_check, array('list-category-post', 'category-post'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.post_category') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-products', 'product', 'product', 'list-category-product', 'category-product', 'list-variable-product', 'variable-product', 'list-combo', 'combo'))){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-products', 'product', 'product', 'list-category-product', 'category-product', 'list-variable-product', 'variable-product', 'list-combo', 'combo'))){ echo 'active'; } ?>">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            {{ trans('admin.product') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.listProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-products', 'product'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.products') }}</p>
                            </a>
                        </li>
                        @if(Auth::guard('admin')->user()->admin_level == 99999)
                        <li class="nav-item">
                            <a href="{{route('admin.listCategoryProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-category-product', 'category-product'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.product_category') }}</p>
                            </a>
                        </li>
                        {{--
                        <li class="nav-item">
                            <a href="{{route('admin.listVariableProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-variable-product', 'variable-product'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>@lang('Variable product')</p>
                            </a>
                        </li>
                        --}}
                        @endif
                    </ul>
                </li>
                
                @php $brand_slug = array('brand', 'list-brand') @endphp
                <li class="nav-item has-treeview <?php if(in_array($segment_check, $brand_slug)){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, $brand_slug)){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Thương hiệu <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.brand')}}" class="nav-link <?php if(in_array($segment_check, array('brand'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Danh sách thương hiệu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.brand.create')}}" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Thêm thương hiệu</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @php $element_slug = array('brand', 'element') @endphp
                <li class="nav-item has-treeview <?php if(in_array($segment_check, $element_slug)){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, $element_slug)){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>{{ trans('admin.element') }} <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin_element.index')}}" class="nav-link <?php if(in_array($segment_check, array('element'))){ echo 'active'; } ?>">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.elements') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin_element.create')}}" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.element_add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('admin.slider')}}" class="nav-link <?php if(in_array($segment_check, array('list-slider', 'slider'))){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-images"></i>
                        <p>{{ trans('admin.sliders') }}</p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-users', 'user'))){ echo 'menu-open'; } ?>">
                    <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-user-admin', 'user'))){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ trans('admin.user') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.listUsers')}}" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.users') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.addUsers')}}" class="nav-link">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>{{ trans('admin.user_add') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.listOrder')}}" class="nav-link <?php if(in_array($segment_check, array('list-order', 'order'))){ echo 'active'; } ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>{{ trans('admin.orders') }}</p>
                    </a>
                </li>
                @endif

                <!-- Setting -->
                @if(Auth::guard('admin')->user()->admin_level == 99999)
                <li class="nav-item">
                    <a href="{{route('admin.email_template')}}" class="nav-link">
                      <i class="nav-icon fas fa-bars"></i>
                      <p>Email template</p>
                    </a>
                  </li>
                  
                <li class="nav-header">Setting</li>
                <li class="nav-item">
                    <a href="{{route('admin.themeOption')}}" class="nav-link">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            {{ trans('admin.theme_option') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.menu')}}" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin_product.import')}}" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Product Import
                        </p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('admin.changePassword')}}" class="nav-link">
                        <i class="nav-icon fa fa-user" aria-hidden="true"></i>
                        <p>{{ trans('admin.account') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.logout')}}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>