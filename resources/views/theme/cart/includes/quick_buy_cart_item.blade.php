<div class="your-order">
    <h4 class="order-title mb-4">Chi tiết đơn hàng</h4>

    <div class="table-responsive-sm order-table">
        <table class="bg-white table table-bordered table-hover text-center">
            <thead>
                <tr>
                    <th class="text-left">Tên SP</th>
                    <th width="20%">Giá</th>
                    <th width="15%">Đơn vị</th>
                    <th>SL</th>
                    <th width="20%">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php $weight = 0; @endphp
                @php 
                    //$product = \App\Product::find($cart->id); 
                    $weight = $weight + $product->weight ;
                @endphp
                <tr>
                    <td class="text-left">{{ $product->name }}</td>
                    <td>{!! render_price($product->price) !!}</td>
                    <td>
                        @if (count($option['options']))
                            @foreach($option['options'] as $groupAttr => $variable)
                                <div>{{ $variable_group[$groupAttr] }}: {!! render_option_name($variable) !!}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $option['qty'] }}</td>
                    <td>{!! render_price($product->price) !!}</td>
                </tr>
            </tbody>
            <tfoot class="font-weight-600">
                <!-- <tr class="shipping">
                    <td colspan="4" class="text-right">Shipping </td>
                    <td class="shipping_cost">Calculated at next step</td>
                </tr> -->
                <tr>
                    <td colspan="4" class="text-right">Tổng tiền</td>
                    <td class="cart_total">{!! render_price($total) !!}</td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="pounds" value="{{ $weight }}">
        <input type="hidden" name="ounces" value="0">
    </div>
</div>