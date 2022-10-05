@php
    $type = $type ?? '';
    $parent = $parent ?? 0;
@endphp
@if($type == '')
<?php 
    $categories = \App\Model\ShopCategory::where('status', 1)->where('parent', 0)->get();
?>
<select class="custom-select mr-2" name="parent">
    <option value="0">== Không có ==</option>
    @if($categories->count() > 0)
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $parent == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>

            @if($category->children)
                @include('admin.product-category.includes.select-category', [
                    'data' => $category->children,
                    'type' => 'option',
                    'parent' => $parent,
                    'slit'  => '&nbsp;&nbsp;&nbsp;&nbsp;'
                ])
            @endif
        @endforeach
    @endif
</select>

@else
    @foreach($data as $item)
    <option value="{{ $item->id }}" {{ $parent == $item->id ? 'selected' : '' }} >{!! $slit !!}{{ $item->name }}</option>
        @if($item->children)
            @include('admin.product-category.includes.select-category', [
                'data' => $item->children,
                'type' => 'option',
                'parent' => $parent,
                'slit'  => $slit .'&nbsp;&nbsp;&nbsp;&nbsp;'
            ])
        @endif
    @endforeach
@endif