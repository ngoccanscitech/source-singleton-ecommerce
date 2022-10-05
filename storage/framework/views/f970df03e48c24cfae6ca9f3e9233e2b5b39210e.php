<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="py-5 my-post bg-light  position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12">

            <div class="page-title">
                <h3>Chi tiết đơn hàng <?php echo e($order->cart_code); ?></h3>
            </div>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/style_customer.css')); ?>">
            <div class="infor-shipping">
                <div class="information-ship">
                    <table class="table table-striped">
                        <tr>
                            <td style="width: 200px;">Mã đơn hàng:</td>
                            <td><b><?php echo e($order->cart_code); ?></b></td>
                        </tr>
                        
                        <tr>
                            <td>Trạng thái đơn hàng:</td>
                            <td><span class="badge cart-status-<?php echo e($order->cart_status); ?>"><?php echo e($statusOrder[$order->cart_status]??'Chờ xác nhận'); ?></span></td>
                        </tr>
                        <tr>
                            <td>Họ tên:</td>
                            <td><?php echo e($order->name); ?></td>
                        </tr>
                        
                        <tr>
                            <td>Điện thoại:</td>
                            <td><?php echo e($order->cart_phone); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo e($order->cart_email); ?></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><?php echo e($order->cart_address); ?></td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán:</td>
                            <td>
                                <?php if($order->payment_method == 'cash'): ?>
                                    <div>- Thanh toán bằng tiền mặt khi nhận hàng</div>
                                <?php elseif($order->payment_method == 'bank_transfer'): ?>
                                    <div class="mb-3">- <?php echo app('translator')->get('bank_transfer'); ?></div>
                                    <div class="ps-3"><?php echo htmlspecialchars_decode(setting_option('banks')); ?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Phương thức nhận hàng:</td>
                            <td>
                                <?php if($order->shipping_type == 'shipping'): ?>
                                    <div>Giao hàng nhanh</div>
                                <?php else: ?>
                                    <div>Nhận hàng tại cửa hàng:</div>
                                    <div class="mt-3"><?php echo htmlspecialchars_decode(setting_option('pickup_address')); ?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if($order->shipping_type == 'shipping'): ?>
                            <?php
                                $address_full = implode(', ', array_filter([$order->cart_address , $order->city, $order->province, $order->country_code]));
                            ?>
                        <tr>
                            <td>Địa chỉ nhận hàng</td>
                            <td><?php echo e($address_full); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Trạng thái thanh toán:</td>
                            <td>
                                <?php if($order->cart_payment == 1): ?>
                                    <span class="badge bg-info"><?php echo e($orderPayment[$order->cart_payment]); ?></span>
                                
                                <?php else: ?>
                                    <span class="badge bg-primary"><?php echo e($orderPayment[$order->cart_payment]??'Chưa thanh toán'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Phí vận chuyển:</td>
                            <td>
                                <?php echo render_price($order->shipping_cost); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td><?php echo e($order->cart_note); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <h4 class="order-product-detail my-2 mt-4">Danh sách sản phẩm</h4>
            <div class="myorder-detail">          
                <div class="table-responsive">          
                <?php
                    // $total_price = isset($order_detail->cart_total) ? $order_detail->cart_total : '';
                    
                    $total_price = isset($order_detail->total) ? $order_detail->total : '';
                    
                        $url_img_sp='/images/product/';
                        $j=0;
                        $count=0;
                        $cart_id=0;
                        $Products=array();
                        $List_cart="";
                        $bg_child_tb="";
                ?>
                <table class="table table-striped" id="tbl-order-detail">
                      <thead>
                        <tr>
                          <th class="text-center" width="30">No</th>
                          <th class="text-center" width="100">Hình ảnh</th>
                          <th class="text-center">Tên SP</th>
                          <th class="text-center">Giá</th>
                          <th class="text-center">SL</th>
                          <th class="text-center">Thành tiền</th>
                        </tr>
                      </thead>
                        <tfoot>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2" style="text-align: right;"><strong>Vận chuyển</strong></td>
                                <td colspan="2" style="text-align: right;">
                                    <span class="sum_price"> 
                                        <b><?php echo render_price($order->shipping_cost); ?></b>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2" style="text-align: right;"><strong>Tổng tiền </strong></td>
                                <td colspan="2" style="text-align: right;">
                                    <span class="sum_price"> 
                                        <b><?php echo render_price( $order->cart_total + $order->shipping_cost); ?></b>
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $__currentLoopData = $order_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $product = \App\Product::find($item->product_id);
                            ?>
                            <tr>
                                <td><?php echo e($index+1); ?></td>
                                <td><img src="<?php echo e(asset($product->image)); ?>" onerror="if (this.src != '/assets/images/no-image.jpg') this.src = '/assets/images/no-image.jpg';" style="width: 70px;"/></td>
                                <td style="border-left-color: rgb(203, 203, 203);">
                                    <a href="<?php echo e(route('shop.detail', $product->slug)); ?>" target="_blank"><?php echo e($product->name); ?></a>
                                </td>
                                <td align="center"><span style="color:#F00;"><?php echo render_price($item->subtotal / $item->quanlity); ?></span></td>
                                <td align="center">
                                    <b><?php echo e($item->quanlity); ?></b>
                                </td>
                                <td align="center"><span class="red"><?php echo render_price($item->subtotal); ?></span></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/cart/view.blade.php ENDPATH**/ ?>