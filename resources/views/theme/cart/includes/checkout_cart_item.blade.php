<div class="your-order">
    <h4 class="order-title mb-4">Đơn hàng</h4>

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
                @foreach($carts as $cart)
                @php $product = \App\Product::find($cart->id); $weight = $weight + ($product->weight * $cart->qty ) ;@endphp
                <tr>
                    <td class="text-left">{{ $product->name }}</td>
                    <td>{!! render_price($cart->price) !!}</td>
                    <td>
                        <div>{{ $product->unit }}</div>
                        @if ($cart->options->count())
                            @foreach($cart->options as $groupAttr => $variable)
                                <div>{{ $variable_group[$groupAttr] }}: {{ render_option_name($variable) }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $cart->qty }}</td>
                    <td style="white-space: nowrap;">{!! render_price($cart->price * $cart->qty) !!}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="font-weight-600">
                <tr>
                    <td colspan="4" class="text-right">Thành tiền</td>
                    <td class="cart_total" style="white-space: nowrap;">{!! render_price(Cart::total(2)) !!}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
