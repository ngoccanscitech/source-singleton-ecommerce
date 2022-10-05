<ul id="muti_menu_post" class="muti_menu_right_category">
    @foreach ($categories as $item)
    @php
        $categories_child = \App\ProductCategory::where('parent', $item->id)->where('status', 1)->get();
    @endphp
    <li class='category_menu_list'>
        <label>
            <input type='checkbox' class='category_item_input' name='category_item[]' value="{{ $item->id }}" {{ in_array($item->id, $checklist) ? 'checked' : '' }}> {{ $item->name }}
        </label>
    </li>
    @if($categories_child->count())
        @foreach($categories_child as $category)
        <li class='category_menu_list pl-4'>
            <label>
                <input type='checkbox' class='category_item_input' name='category_item[]' value="{{ $category->id }}" {{ in_array($category->id, $checklist) ? 'checked' : '' }}> {{ $category->name }}
            </label>
        </li>
        @endforeach
    @endif
    @endforeach
</ul>