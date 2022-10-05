<div class="engine pd-t-50">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-pro-sigle">
                <div class="wrap-cont-engine">
                    <div class="box-cont-pro-single">
                        <div class="box-cont-pro-single">
                            <div class="cont-pro-single">
                                <h4 class="tit-cont-pro-single  text-uppercase">{{ $field['name'] }}</h4>
                                {!! htmlspecialchars_decode($field['desc']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @if($field['image'])
                <div class="box-thumb-pro-single">
                    <img src="{{ asset($field['image']) }}" alt="">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>