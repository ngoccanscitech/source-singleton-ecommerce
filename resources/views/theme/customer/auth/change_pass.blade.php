@php
    extract($data)
@endphp

@extends($templatePath .'.layouts.index')

@section('seo')
@endsection

@section('content')

    <section class="py-3 my-post bg-light  position-relative">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12">
                    <div class="border bg-white px-2">
                        <div class="agent-contact mb-3">
                            <div class="text-center pt-3">
                                <div class="avatar">
                                  <!-- <img class="img-fluid rounded-circle avatar avatar-xl" src="images/avatar/01.jpg" alt=""> -->
                                    @if(auth()->user()->avatar)
                                        <img src="{{  auth()->user()->avatar }}" alt="">
                                    @else
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                    @endif
                                </div>
                                <div class="agent-contact-name mt-2">
                                  <h6>{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="widget mb-3">
                            <div class="widget-title">
                                <h6>Quản lý thông tin tài khoản</h6>
                            </div>
                            <a class="dropdown-item" href="{{ route('customer.my-orders') }}">
                                <img src="/upload/images/general/list.svg" class="icon_menu"> Your order
                            </a>
                            <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                <img src="/upload/images/general/user.svg" class="icon_menu"> Your Info
                            </a>
                            <a class="dropdown-item" href="{{ route('customer.changePassword') }}">
                                <img src="/upload/images/general/lock.svg" class="icon_menu"> Change password
                            </a>
                            <hr>
                            <a class="dropdown-item" href="{{ route('customer.logout') }}"><img src="/upload/images/general/logout.svg" class="icon_menu"> Logout</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="section-title mb-3 d-flex align-items-center">
                      <h4>Thay đổi thông tin</h4>
                    </div>
                    <form action="{{ route('customer.post.ChangePassword') }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                @if (count($errors) >0)
                                    @foreach($errors->all() as $error)
                                      <div class="text-danger mb-3"> {{ $error }}</div>
                                    @endforeach
                                 @endif
                                 @if (session('status'))
                                    <div class="text-danger mb-3"> {{ session('status') }}</div>
                                 @endif
                                <div class="form-groupmb-3">
                                      <label class="mb-2">Mật khẩu hiện tại</label>
                                      <input type="password" class="form-control" name="current_password" >
                                </div>
                                <hr>
                                <div class="form-group mb-3">
                                  <label class="mb-2">Mật khẩu mới</label>
                                  <input type="password" class="form-control" name="new_password" value="">
                                </div>
                                <div class="form-group  mb-3">
                                  <label class="mb-2">Nhập lại mật khẩu mới</label>
                                  <input type="password" class="form-control" name="confirm_password" value="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-3 text-center">
                              <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    
    @push('after-footer')
    <script src="{{ asset('theme/js/customer.js') }}"></script>
    @endpush
@endsection
