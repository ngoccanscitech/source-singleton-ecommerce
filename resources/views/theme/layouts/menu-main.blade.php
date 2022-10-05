<ul class="nav-menu d-inline">
	@foreach($headerMenu as $value)
		@php
			$class_active ='';
		@endphp
		@if(empty($value['child']))
			<li class="{{$class_active}}"><a href="{{$value['link']}}">{{$value['label']}}</a></li>
		@else
			<li class="chev-right {{$class_active}}"><a href="{{$value['link']}}">{{$value['label']}}</a>
				<ul class="child child-1">
					@foreach($value['child'] as $value_child)
					@php
						$class_active_child="";
					@endphp
					@if(empty($value_child['child']))
						<li class="{{$class_active_child}}"><a href="{{$value_child['link']}}">{{$value_child['label']}}</a></li>
					@else
						<li class="chev-right {{$class_active_child}}"><a href="{{$value_child['link']}}">{{$value_child['label']}}</a></i>
						<ul class="child child-2">
						@foreach($value_child['child'] as $value_child_2)
						<li><a href="{{$value_child_2['link']}}">{{$value_child_2['label']}}</a></li>
						@endforeach
						<li><button id="btn-show-f-search" type="button" class="btn-search"><i class="fas fa-search"></i></button></li>
						</ul>
						</li>
					@endif
				@endforeach
				</ul>
			</li>
		@endif
	@endforeach
	<li></li>
</ul>