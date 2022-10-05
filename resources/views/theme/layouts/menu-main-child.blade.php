<div class="dropdown-menu">
	@foreach ($data as $menu)
		@php
			$link = app()->isLocale('vi') ? url($lc .'/'. $menu['link']) : url($menu['link'])
		@endphp
	    <a class="dropdown-item" href="{{ $link }}">{{ $menu['label'] }}</a>
    @endforeach
</div>
