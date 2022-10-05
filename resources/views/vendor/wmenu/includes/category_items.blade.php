<?php 
    if(!isset($parent_id))
        $parent_id = 0;
    $dategories = \App\Model\ShopCategory::where('parent', $parent_id)
            ->orderByDesc('priority')->get();
?>
@if(count($dategories)>0)
    @foreach($dategories as $category)
        <label for="page_{{ $category->id }}" class="form-group {{ $parent_id != 0 ? 'pl-4' : '' }}">
            <input type="checkbox" class="category_item_input" value="{{ $category->id }}" id="page_{{ $category->id }}" >
            {{ $category->name }}

            <input type="hidden" class="item-name-{{ $category->id }}" value="{{ $category->name }}">
            <input type="hidden" class="item-url-{{ $category->id }}" value="{{ $category->slug.'.html' }}">
        </label>
        @if(count($category->children)>0)
            @include('vendor.wmenu.includes.category_items', ['parent_id'=> $category->id])
        @endif
    @endforeach
@endif