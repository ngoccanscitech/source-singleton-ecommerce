<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'Order Detail: '.$order_detail->cart_code.' | E-Bike Dashboard',
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Order Detail: '.$order_detail->cart_code.' | E-Bike Dashboard',
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);

$total_price = isset($order_detail->cart_total) ? $order_detail->cart_total : '';
$cart_content_cart = unserialize($order_detail->cart_content);
$order_products = \App\Model\Addtocard_Detail::where('cart_id', $order_detail->cart_id)->get();
?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Order Detail: <?php echo e($order_detail->cart_code); ?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Order Detail: <?php echo e($order_detail->cart_code); ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <form action="<?php echo e(route('admin.postOrderDetail', array($order_detail->cart_id))); ?>" method="POST" id="frm-order-detail">
        <?php echo csrf_field(); ?>
        <div class="row">
          <input type="hidden" name="cart_id" value="<?php echo e($order_detail->cart_id); ?>">
          <input type="hidden" name="cart_code" value="<?php echo e($order_detail->cart_code); ?>">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin khách hàng</h3>
                </div> <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                            <td style="width: 200px;">Mã đơn hàng:</td>
                            <td><?php echo e($order_detail->cart_code); ?></td>
                        </tr>
                        
                        <tr>
                            <td>Họ tên:</td>
                            <td><?php echo e($order_detail->name); ?></td>
                        </tr>
                        
                        <tr>
                            <td>Điện thoại:</td>
                            <td><?php echo e($order_detail->cart_phone); ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo e($order_detail->cart_email); ?></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><?php echo e($order_detail->cart_address); ?></td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán:</td>
                            <td>
                                <?php if($order_detail->payment_method == 'cash'): ?>
                                    <div>- Thanh toán bằng tiền mặt khi nhận hàng</div>
                                <?php elseif($order_detail->payment_method == 'bank_transfer'): ?>
                                    <div class="mb-3">- <?php echo app('translator')->get('bank_transfer'); ?></div>
                                    <?php echo htmlspecialchars_decode(setting_option('banks')); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Phương thức nhận hàng:</td>
                            <td>
                                <?php if($order_detail->shipping_type == 'shipping'): ?>
                                   
                                    <div>Giao hàng nhanh</div>
                                
                                <?php else: ?>
                                    <div>Nhận hàng tại cửa hàng:</div>
                                    <div class="mt-3"><?php echo htmlspecialchars_decode(setting_option('pickup_address')); ?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if($order_detail->shipping_type == 'shipping'): ?>
                            <?php
                                $address_full = implode(', ', array_filter([$order_detail->cart_address , $order_detail->city, $order_detail->province, $order_detail->country_code]));
                            ?>
                        <tr>
                            <td>Địa chỉ nhận hàng</td>
                            <td><?php echo e($address_full); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Trang thái thanh toán:</td>
                            <td>
                                <?php if($order_detail->cart_payment == 1): ?>
                                    <span class="badge bg-info"><?php echo e($orderPayment[$order_detail->cart_payment]); ?></span>
                                
                                <?php else: ?>
                                    <span class="badge bg-primary"><?php echo e($orderPayment[$order_detail->cart_payment]??'Chưa thanh toán'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Phí vận chuyển:</td>
                            <td>
                                <?php echo render_price($order_detail->shipping_cost); ?>

                            </td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td><?php echo e($order_detail->cart_note); ?></td>
                        </tr>
                  </tbody>
                </table>
              </div> <!-- /.card-body -->
                </div><!-- /.card -->
          </div>
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
               </div> <!-- /.card-header -->
               <div class="card-body p-0">
                  <?php if($order_products->count()): ?>
                  <table class="table table-striped" id="tbl-order-detail">
                     <thead>
                        <tr>
                           <th>STT</th>
                           <th>Tên sản phẩm</th>
                           <th>Hình ảnh</th>
                           <th>Giá</th>
                           <th>Số lượng</th>
                           <th>Thành tiền</th>
                        </tr>
                     </thead>
                     <tfoot>
                        <?php if($order_detail->shipping_cost): ?>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td colspan="2">Phí ship</td>
                            <td colspan="1">
                                 <div class="fee_ship"><?php echo render_price($order_detail->shipping_cost); ?></div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td colspan="2"><strong>Tổng tiền</strong></td>
                            <td colspan="1">
                                 <div><span class="sum_price"><?php echo render_price($total_price + $order_detail->shipping_cost); ?></span> </div>
                            </td>
                        </tr>
                     </tfoot>
                     <tbody>
                        <?php $__currentLoopData = $order_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                           $product = \App\Product::find($order_item->product_id);
                        ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td style="border-left-color: rgb(203, 203, 203);">
                                <a href="<?php echo e(route('shop.detail', $product->slug)); ?>" target="_blank"><?php echo e($product->name); ?></a><br/>
                                
                            </td>
                            <td>
                              <?php if($product->image): ?>
                                 <img src="<?php echo e(asset($product->image)); ?>" height="50"/>
                              <?php endif; ?>
                           </td>
                            <td align="center">
                              <span style="color:#F00;"><?php echo render_price($order_item->subtotal/$order_item->quanlity); ?></span>
                           </td>
                            <td align="center">
                                <b><?php echo e($order_item->quanlity); ?></b>
                            </td>
                            <td align="center"><span class="red"><?php echo render_price($order_item->subtotal); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
                  <?php endif; ?>
              </div> <!-- /.card-body -->
            </div><!-- /.card -->
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title mb-0">Dành cho quản trị viên cập nhật đơn hàng</h3>
              </div> <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <tbody>
                     <tr>
                        <td>Phí vận chuyển:</td>
                        <td>
                           <input type="number" name="shipping_cost" value="<?php echo e($order_detail->shipping_cost); ?>" class="form-control">
                        </td>
                     </tr>
                     <tr>
                        <td>Thanh toán:</td>
                        <td>
                           <select name="cart_payment" class="form-control">
                                <?php $__currentLoopData = $orderPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($key); ?>" <?php echo e($order_detail->cart_payment == $key ? 'selected' : ''); ?>><?php echo e($item); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td>Tình trạng</td>
                        <td>
                           <select name="cart_status" class="form-control">
                              <?php $__currentLoopData = $statusOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($key); ?>" <?php echo e($order_detail->cart_status == $key ? 'selected' : ''); ?>><?php echo e($item); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </td>
                     </tr>
                    <tr>
                      <td>Ghi chú:</td>
                      <td>
                        <textarea id="admin_note" name="admin_note"><?php echo htmlspecialchars_decode($order_detail->cart_excerpt); ?></textarea>
                      </td>
                    </tr>
                    
                    <tr>
                      <td colspan="2" style="text-align: right;">
                        <input type="submit" name="btn_submit_order" class="btn btn-success" value="Cập nhật đơn hàng">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> <!-- /.card-body -->
            </div><!-- /.card -->
              </div> <!-- /.col -->
          </div> <!-- /.row -->
      </form>
    </div> <!-- /.container-fluid -->
</section>
<script>
  $(function () {
   editorQuote('admin_note');
  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/orders/single.blade.php ENDPATH**/ ?>