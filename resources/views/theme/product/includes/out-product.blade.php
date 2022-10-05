<div class="out-product pd-t-50">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-pro-sigle">
                <div class="box-cont-pro-single">
                    <h4 class="tit-cont-pro-single text-uppercase">{{ $field['name'] }}</h4>
                    {!! htmlspecialchars_decode($field['desc']) !!}
                </div>
            </div>
            @if($field['image'])
            <div class="col-md-8 col-pro-sigle">
                <div class="box-thumb-pro-single">
                    <img src="{{ asset($field['image']) }}" alt="">
                </div>
            </div>
            @endif
        </div>  
    </div>  
</div>  