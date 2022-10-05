<?php 
	if($slider_id){
		$sliders = \App\Model\Slider::where('slider_id', $slider_id)->orderBy('order', 'asc')->get();
	}
?>
@if(isset($sliders) && count($sliders)>0)
	<div class="form-group row border py-2">
		<div class="col-md-3">Hình ảnh</div>
		<div class="col-md-3">Tên</div>
		<div class="col-md-3">Link</div>
		<div class="col-md-3">Action</div>
	</div>
	@foreach($sliders as $item)
	<div class="form-group row mb-2 pb-2 border-bottom">
		<div class="col-md-3">
			<img src="{{ asset($item->src) }}" alt="" style="height: 50px;">
		</div>
		<div class="col-md-3">
			{{ $item->name }}
		</div>
		<div class="col-md-3">
			{{ $item->link }}
		</div>
		<div class="col-md-3 d-flex align-items-center">
			<button type="button" class="btn btn-sm btn-info edit-slider" data="{{ $item->id }}">Edit</button>
			<button type="button" class="btn btn-sm btn-danger delete-slider ml-2" data="{{ $item->id }}">Delete</button>
		</div>
	</div>
	@endforeach
@endif