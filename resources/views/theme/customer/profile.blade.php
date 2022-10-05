@php
    $states = \App\Model\Province::get();
@endphp

@extends($templatePath .'.layouts.index')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')

    <section class="py-5 my-post bg-light  position-relative">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9 col-12">
                    <div class="section-title mb-3 d-flex align-items-center justify-content-center">
                      <h2>Thông tin cá nhân</h2>
                    </div>
                    <form action="{{ route('customer.updateprofile') }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                              <label class="mb-2">Họ tên</label>
                              <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="mb-2">Email</label>
                              <input type="text" class="form-control" readonly value="{{ $user->email }}">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="mb-2">Điện thoại</label>
                              <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>
                        <hr>
                        <h6 class="mt-2">Địa chỉ nhận hàng</h6>
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                              <label class="mb-2">Địa chỉ</label>
                              <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                            </div>
                            <div class="form-group col-md-6 col-lg-4 col-xl-4 required">
                                <label for="state_province">Tỉnh / Thành phố <span class="required-f">*</span></label>
                                <select name="state" id="state_province" class="form-control">
                                    <option value=""> --- Chọn tỉnh/thành phố --- </option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ $state->id == $user->province ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 mt-3 mb-5">
                              <h6>Cập nhật ảnh đại diện</h6>
                              <p>Vui lòng chọn ảnh hình vuông, kích thước khoảng 500px x 500px</p>
                              <div class="input-group file-upload">
                                <input type="file" name="avatar_upload" class="form-control" id="customFile">
                                <label class="input-group-text" for="customFile">Chọn file</label>
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

@endsection

@push('after-footer')
<script src="{{ asset('theme/js/customer.js') }}"></script>
@endpush
