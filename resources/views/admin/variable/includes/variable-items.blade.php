@php
	$childs = \App\Model\Variable::where('parent', $data->id)->where('status',0)->get();
@endphp
@if(isset($data))
<table width="100%" border="0" class="table_variable_child_{{ $data->id }} table_child_bt">
    <tr>
        <th align="center"></th> 
        <th align="center">STT</th> 
        <th align="center">Title</th>
        <th align="center">Slug</th>
    </tr>
    @foreach($childs as $item)
    	<tr>
            <td class="text-center">
            	<input type="checkbox" id="'.$item->id.'" name="seq_list[]" value="{{ $item->id }}">
            </td>
            <td>{{ $item->stt ?? 0 }}</td>
            <td class="name_varibles" align="center">
            	<a href="{{ route('admin.variableProductDetail', array($item->id)) }}">
            		<i class="{{ $item->icon }}"></i>
            		{{ $item->name }}
            	</a>
            </td>
            <td class="slug_varibles" align="center">
            	{{ $item->slug }}
            </td>
        </tr>
    @endforeach
</table>
@endif