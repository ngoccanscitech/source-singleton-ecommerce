@if(count($data)>0)
    @foreach($data as $item)
        <ul id="muti_menu_post" class="muti_menu_right_category">
            <li class="active category_menu_list">
                <label for="checkbox_{{ $item->id }}">
                    <input type="checkbox" class="category_item_input" name="category[]" value="{{ $item->id }}" id="checkbox_{{ $item->id }}" {{ in_array($item->id, $id_selected) ? 'checked' : '' }}>
                    {{ $item->title }}
                </label>
            </li>
        </ul>   
    @endforeach
@endif