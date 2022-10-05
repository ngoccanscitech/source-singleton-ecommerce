<?php 
    $pages = \App\Model\Page::where('status', 0)
            ->orderByDesc('id')->get();
?>
@if(count($pages)>0)
    @foreach($pages as $page)
        <label for="category_{{ $page->id }}" class="form-group">
            <input type="checkbox" class="category_item_input" value="{{ $page->id }}" id="category_{{ $page->id }}" >
            {{ $page->title }}

            <input type="hidden" class="item-name-{{ $page->id }}" value="{{ $page->title }}">
            <input type="hidden" class="item-url-{{ $page->id }}" value="{{ $page->slug }}">
        </label>
    @endforeach
@endif