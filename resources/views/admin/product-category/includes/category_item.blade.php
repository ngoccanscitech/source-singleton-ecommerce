<?php 
    
    //$parent_id = $parent_id ?? 0;
    //$dategories = \App\Model\ShopCategory::where('parent', $parent_id)->orderByDesc('preority')->get();
?>
@if(count($categories)>0)
    @foreach($categories as $data)
        <tr class="tr-item item-level-{{ isset($level) ? $level : 0 }}">
            <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
            <td class="text-center stt">{{$data->priority}}</td>
            <td class="title">
                <a class="row-title " href="{{route('admin.categoryProductDetail', array($data->id))}}">
                    <div><b style='color: #056FAD;'>{{$data->name}}</b></div>
                </a>
                <div>
                    <b style='color:#777;'>URL:</b>
                    <a style='color:#00C600; word-break:break-all;' target='_blank' href="{{route('shop.detail', ['slug'=>$data->slug])}}">{{route('shop.detail', ['slug'=>$data->slug])}}</a>
                </div>

            </td>
            <td class="text-center">
                @if($data->image != null)
                    <img src="{{ asset($data->image) }}" style="height: 70px">
                @endif
            </td>
            <td class="text-center">
                {{ $data->updated_at }}
                <br>
                {{ $data->status == 1 ? 'Public' : 'Draft' }}
            </td>
        </tr>
        @if(count($data->children)>0)
            @include('admin.product-category.includes.category_item', [
                'categories'=> $data->children, 
                'level'=>$level+1
            ])
        @endif
    @endforeach
@endif