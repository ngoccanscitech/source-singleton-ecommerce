<?php 
    $product_id = $product ? $product->id : 0;
    $attr_id = $attr_id ?? '';
    $attr_list_selected = $attr_list_selected ?? 0;

    $variables_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
    

    $attr_selected = '';
    $attr_selected_second = '';


    // $current = '';
?>
    <!-- <form action="" method="post" id="form-attr"> -->
        <input type="hidden" name="attr_id">
        <input type="hidden" name="product" value="{{ $product->id }}">
    @foreach($variables_group as $group_id => $variable)
        <?php 
            $product_attr = $product->getVariable($group_id);

            if($attr_id && isset($attr_id[$group_id])){
                $attr_selected = $product_attr->where('variable_id', $attr_id[$group_id])->first();
                // dd($attr_id[$group_id]);
            }

            if($attr_selected == ''){
                $attr_selected = $product_attr->first();
            }
            else{
                $attr_selected_second = $product_attr->where('parent', $attr_selected->id)->first();
                // dd($attr_selected_second);
            }

            // dd($product_attr);
        ?>
            @if($product_attr->count())
            <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                <div class="product-form__item">
                    <label class="header">{{ $variable }}: 
                        @if($attr_selected_second)
                        <span class="slVariant">{{ $attr_selected_second->getVariable->name }}</span>
                        @else
                        <span class="slVariant">{{ $attr_selected->getVariable->name }}</span>
                        @endif
                    </label>
                    
                    @foreach($product_attr as $index => $attr)
                        @php
                            $value = $attr->getVariable->name;
                            $checked = '';
                            $disable = '';

                            if(isset($attr_list_selected[$group_id])){
                                $attr_list_selected_item = explode('__', $attr_list_selected[$group_id]);
                            }

                            if(isset($attr_list_selected_item) && $attr_list_selected_item[0] == $attr->getVariable->name ){
                                $checked = 'checked';
                                $value =  $attr->getVariable->name .'__'. $attr->price .'__'. $attr->promotion;
                            }
                            elseif($attr_selected->id == $attr->id){
                                $checked = 'checked';
                                $value =  $attr->getVariable->name .'__'. $attr_selected->price .'__'. $attr_selected->promotion;
                            }
                            elseif($attr_selected_second != '' && $attr_selected_second->id == $attr->id){
                                $checked = 'checked';
                                $value =  $attr->getVariable->name .'__'. $attr_selected_second->price .'__'. $attr_selected_second->promotion;
                            }
                            

                            if($attr_selected_second != ''){
                                $check_ = \App\Model\ThemeVariable::with('getVariableParent')->whereHas('getVariableParent', function($query) use($attr_selected){
                                    return $query->where('variable_id', $attr_selected->variable_id);
                                })->where('theme_id', $product->id)->pluck('variable_id');
                                
                                if(in_array($attr->variable_id, $check_->toArray()))
                                    $disable = '';
                                else
                                    $disable = 'disabled';
                            }
                        @endphp
                        <div data-value="{{ $attr->getVariable->name }}" class="swatch-element available available-item">
                            <input class="swatchInput" id="swatch-{{ $group_id }}-{{ $attr->getVariable->slug }}" type="radio" name="option[{{ $group_id }}]" 
                                value="{{ $value }}" 
                                data-id="{{ $attr->getVariable->id }}"
                                {{ $checked ?? '' }} 
                                {{ $disable ?? '' }} 
                                data-parent="{{ $attr->variable_parent ?? 0 }}"
                            >
                            <label class="swatchLbl small flat" for="swatch-{{ $group_id }}-{{ $attr->getVariable->slug }}">{{ $attr->getVariable->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
    @endforeach
    <!-- </form> -->
    {{--<p class="infolinks mb-3"><a href="#sizechart" class="sizelink btn"> Size Guide</a> <a href="#productInquiry" class="emaillink btn"> Ask About this Product</a></p>--}}
