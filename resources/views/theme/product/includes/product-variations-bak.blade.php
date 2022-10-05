<?php 
    $product_id = $product ? $product->id : 0;
    $attr_id = $attr_id ?? 0;
    $variables = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->get();
    $attr_selected = $attr_selected ?? '';
?>
    @foreach($variables as $variable)
        <?php 
            $product_attr = $product->getVariable($variable->id);
        ?>
        @if($product_attr->count())
            @if($variable->slug =='color' || $variable->slug =='mau-sac')
                @php
                if($attr_id){
                    $color_selected = $product_attr->where('variable_id', $attr_id)->first();
                    $attr_selected = $product_attr->where('variable_id', $attr_id)->first();
                }
                
                else{
                    $color_selected = $product_attr->first();
                    $attr_selected = $product_attr->first();
                }
                
                @endphp
                @if($product_attr->count())
                <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                    <div class="product-form__item product-form__item_color">
                        <label class="header">{{ $variable->name }}: <span class="slVariant">{{ $color_selected->getVariable->name }}</span></label>
                        @foreach($product_attr as $index => $attr)
                        <div data-value="{{ $attr->getVariable->name }}" class="swatch-element color black available">
                            <input class="swatchInput" id="swatch-{{ $attr->id }}-{{ $attr->slug }}" type="radio" 
                                name="option-{{ $variable->id }}" 
                                data-type="{{$variable->slug}}" 
                                value="{{ $attr->getVariable->name.'_'.$attr->getFinalPrice() }}" 
                                data-id="{{ $attr->getVariable->id }}"
                                {{ $color_selected->variable_id == $attr->variable_id  ? 'checked' : '' }}
                            >
                            <label class="swatchLbl color small rounded" for="swatch-{{ $attr->id }}-{{ $attr->slug }}" title="{{ $attr->getVariable->name }}">
                                <img src="{{ asset($attr->getVariable->image) }}" alt="">
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @else
            <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                <div class="product-form__item">
                    <label class="header">{{ $variable->name }}: <span class="slVariant">{{ $product_attr->first()->getVariable->name }}</span></label>
                    @php  $c = 0; @endphp
                    @foreach($product_attr as $index => $attr)
                        @php
                            $list_child_data = \App\Model\ThemeVariable::with('getVariableParent');
                            if(isset($color_selected))
                                $list_child_data->whereHas('getVariableParent', function($query) use($color_selected){
                                    return $query->where('variable_id', $color_selected->variable_id);
                                });
                            $list_child_data = $list_child_data->where('theme_id', $product->id)->get();
                            $list_child = [];
                            if($list_child_data->count())
                                foreach($list_child_data as $child){
                                    $list_child[] = $child->variable_id;
                                }
                            $disable = 'disabled';
                            $checked = '';
                            if (in_array($attr->variable_id, $list_child)){
                                $disable = '';
                                if($c == 0)
                                    $checked = 'checked';
                                $c=1;
                            }
                            elseif (in_array($attr_id, $list_child)){
                                $disable = '';
                                if($c == 0)
                                    $checked = 'checked';
                                $c=1;
                            }
                        @endphp
                        <div data-value="{{ $attr->getVariable->name }}" class="swatch-element available available-item">
                            <input class="swatchInput" id="swatch-{{ $variable->id }}-{{ $attr->getVariable->slug }}" type="radio" name="option-{{ $variable->id }}" 
                                value="{{ $attr->getVariable->name }}" 
                                data-id="{{ $attr->getVariable->id }}"
                                {{ $checked }} 
                                {{ $disable }} 
                                data-parent="{{ $attr->getVariableParent ? $attr->getVariableParent->parent : '' }}"
                            >
                            <label class="swatchLbl small flat" for="swatch-{{ $variable->id }}-{{ $attr->getVariable->slug }}" title="{{ $attr->getVariable->name }}">{{ $attr->getVariable->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
    @endforeach
    <p class="infolinks mb-3"><a href="#sizechart" class="sizelink btn"> Size Guide</a> <a href="#productInquiry" class="emaillink btn"> Ask About this Product</a></p>
        