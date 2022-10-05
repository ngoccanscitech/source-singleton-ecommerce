@php
    $custom_fields = $custom_field ?? '';
    if($custom_fields != ''){
        $custom_fields = json_decode($custom_fields, true);
        end($custom_fields);         // move the internal pointer to the end of the array
        $key_index = key($custom_fields);
    }
    //dd($custom_fields);

    $listClass = (new \App\Model\ShopProduct)->listClass();
@endphp
<div class="custom_field">
    <div class="row mb-2">
        <div class="col-5 border-bottom pb-1">Tiêu đề</div>
        <div class="col-5 border-bottom pb-1">Nội dung</div>
        <div class="col-2 border-bottom pb-1"></div>
    </div>
    <div class="spec-short-clone" data="{{ $key_index ?? 0 }}" style="display: none;">
        <div class="form-group row group-item">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12 mb-2">
                        <input type="text" class="form-control spec-short-name" name="">
                    </div>
                    <div class="col-12">
                        <div class="group_item_images">
                            <div class="inside d-flex">
                                <div class="image-view mr-2">
                                    <img class="gallery-view" src="{{asset('assets/images/placeholder.png')}}" style="height: 38px;">
                                </div>
                                <div class="input-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="gallery[]" id="gallery-input" value="">
                                        <div class="input-group-append">
                                        <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="gallery-item">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--group_item_images-->
                    </div>
                    {{--
                    <div class="col-12">
                        <div class="form-group mb-1 mt-2">
                          
                          <label><input type="radio" id="image_position_left" name="image_position"> Hình ảnh bên trái nội dung</label>
                        </div>
                        <div class="form-group">
                          
                          <label ><input type="radio" id="image_position_right" name="image_position" > Hình ảnh bên phải nội dung</label>
                        </div>
                    </div>
                    --}}
                    @if($listClass)
                    <div class="col-12">
                        <select name="" class="form-control class">
                            <option value="">Chọn Class</option>
                            @foreach($listClass as $key => $class)
                            <option value="{{ $key }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <textarea class="form-control desc" name=""></textarea>
                <div class="text-red">Vui lòng bấm <b>cập nhật</b> Sản phẩm để hiện chức năng chỉnh sửa text</div>
            </div>
            <div class="col-xl-1 col-lg-2">
                <button type="button" class="btn btn-danger w-100 text-center spec-remove">Xóa</button>
            </div>
        </div>
    </div>
    <div class="spec-short-group">
        @if($custom_fields != '' && is_array($custom_fields))
        <?php //dd($spec) ?>
            @foreach($custom_fields as $index => $item)
                <div class="form-group row group-item">
                    <div class="col-lg-4">
                        

                        <div class="row">
                            <div class="col-12 mb-2">
                                <input type="text" class="form-control spec-short-name" name="custom_field[{{ $index }}][name]" value="{{ $item['name'] ?? '' }}">
                            </div>
                            <div class="col-12">
                                <div class="group_item_images">
                                    <div class="inside d-flex">
                                        <div class="image-view mr-2">
                                            <img class="gallery-view-{{ $index }}" src="{{ isset($item) && $item['image'] != '' ? asset($item['image']) : asset('assets/images/placeholder.png')}}" style="height: 38px;">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="custom_field[{{ $index }}][image]" id="gallery-input-{{ $index }}" value="{{ $item['image'] ?? '' }}">
                                                <div class="input-group-append">
                                                <button class="btn btn-outline-secondary ckfinder-popup" type="button" id="gallery-item-{{ $index }}" 
                                                    data="gallery-input-{{ $index }}"
                                                    data-show="gallery-view-{{ $index }}"
                                                    >Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--group_item_images-->
                            </div>
                            {{--
                            <div class="col-12">
                                @php
                                    $image_position = $item['image_position'] ?? '';

                                @endphp
                                <div class="form-group mb-1 mt-2">
                                  <label><input type="radio" id="image_position_left_{{ $index }}" name="custom_field[{{ $index }}][image_position]" value="left" {{ $image_position== 'left' ? 'checked' : '' }}> Hình ảnh bên trái nội dung</label>
                                </div>
                                <div class="form-group">
                                  <label> <input type="radio" id="image_position_right_{{ $index }}" name="custom_field[{{ $index }}][image_position]" value="right" {{ $image_position== 'right' ? 'checked' : '' }}>Hình ảnh bên phải nội dung</label>
                                </div>
                            </div><!-- image position -->
                            --}}
                            @if($listClass)
                            <div class="col-12">
                                <select name="custom_field[{{ $index }}][class]" class="form-control class">
                                    <option value="">Chọn Class</option>
                                    @foreach($listClass as $key => $class)
                                    <option value="{{ $key }}" {{ (isset($item['class']) && $key == $item['class']) ? 'selected' : '' }}>{{ $class }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-xl-7">
                        <textarea name="custom_field[{{ $index }}][desc]">{!! $item['desc'] ?? '' !!}</textarea>
                    </div>
                    <div class="col-xl-1 col-lg-2">
                        <button type="button" class="btn btn-danger w-100 text-center spec-remove">Xóa</button>
                    </div>
                </div>
                @push('scripts')
                <script>
                    editorQuote('custom_field[{{ $index }}][desc]');
                </script>
                @endpush
            @endforeach
        @endif
    </div>
    <div class="spec-btn text-right">
        <button type="button" class="btn btn-primary custom_field-add">Thêm trường</button>
    </div>
</div>


@push('scripts')
<script>
    jQuery(document).ready(function($) {
        var custom_field = $('.custom_field');
        if(custom_field.length > 0){
            $(document).on('click', '.custom_field .ckfinder-popup', function(){
                var id = $(this).attr('id'),
                    input = $(this).attr('data'),
                    view_img = $(this).data('show');
                selectFileWithCKFinder( input, view_img );
            })
            $('.custom_field-add').click(function(){
                var id = custom_field.find('.spec-short-clone').attr('data');
                id = parseInt(id) + 1;
                custom_field.find('.spec-short-clone').attr('data', id);
                
                var html = custom_field.find('.spec-short-clone').find('.group-item').clone();
                html.find('input.spec-short-name').attr('name', 'custom_field[' + id + '][name]');
                html.find('textarea.desc').attr('name', 'custom_field[' + id + '][desc]');
                html.find('#gallery-item').attr('id', 'gallery-item-' + id).attr('data', "gallery-input-"+ id).attr('data-show', "gallery-view-"+ id);
                html.find('.gallery-view').attr('class', 'gallery-view-' + id);
                html.find('#gallery-input').attr('id', 'gallery-input-' + id);
                html.find('input[name="gallery[]"]').attr('name', 'custom_field[' + id + '][image]');
                html.find('#image_position_left').attr('id', '#image_position_left_'+ id).attr('name', 'custom_field[' + id + '][image_position]');
                html.find('#image_position_right').attr('id', '#image_position_right_'+ id).attr('name', 'custom_field[' + id + '][image_position]');
                html.find('select.class').attr('name', 'custom_field[' + id + '][class]');
                custom_field.find('.spec-short-group').append(html);
            });

            $(document).on('click', '.custom_field .spec-remove', function(){
                $(this).closest('.form-group').remove();
            });
        }
    });

</script>
@endpush