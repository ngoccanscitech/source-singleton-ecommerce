<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'List Orders | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List Orders | '.Helpers::get_option_minhnn('seo-title-add'),
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">List Orders</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h4>List Orders</h4>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('order')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    
                                    <input type="text" class="form-control" name="cart_code" id="cart_code" placeholder="Mã đơn hàng" value="<?php echo e(request('cart_code')??''); ?>">
                                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <a class="btn <?php echo e(request('cart_status')!='' ? 'btn-outline-primary' : 'btn-primary'); ?>" href="<?php echo e(url()->current()); ?>">Tất cả (<?php echo e((new \App\Model\Addtocard)->count()); ?>)</a>
                                <?php $__currentLoopData = $statusOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $order_count = (new \App\Model\Addtocard)->where('cart_status', $key)->count();
                                ?>
                                <a class="btn <?php echo e(request('cart_status') == $key ? 'cart-status-'. $key : 'btn-outline-dark'); ?>" href="<?php echo e(url()->current()); ?>?cart_status=<?php echo e($key); ?>"><?php echo e($item); ?> (<?php echo e($order_count); ?>)</a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                <?php echo $data_order->appends(request()->input())->links(); ?>

                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Tên khách hàng</th>
                                        <th scope="col" class="text-center">Thời gian đặt</th>
                                        <th scope="col" class="text-center">Tổng tiền</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="<?php echo e($data->cart_id); ?>" name="seq_list[]" value="<?php echo e($data->cart_id); ?>"></td>
                                        <td class="text-center">
                                            <a class="row-title" href="<?php echo e(route('admin.orderDetail', array($data->cart_id))); ?>">
                                                <b><?php echo e($data->cart_code); ?></b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="row-title" href="<?php echo e(route('admin.orderDetail', array($data->cart_id))); ?>">
                                                <?php echo e($data->cart_email); ?>

                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e($data->created_at); ?>

                                        </td>
                                        <td class="text-center">
                                            <span class='b' style='color: red;'><?php echo number_format($data->cart_total); ?> đ</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge cart-status-<?php echo e($data->cart_status); ?>"><?php echo e($statusOrder[$data->cart_status]??'Chờ xác nhận'); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $data_order->appends(request()->input())->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>

<style type="text/css">
    .cart-status-1{
        color: #fff !important;
        background-color: #007bff!important;
    }
    .cart-status-2{
        color: #fff !important;
        background-color: #17a2b8!important;
    }
    .cart-status-3{
        color: #fff !important;
        background-color: #dc3545!important;
    }
    .cart-status-4{
        background-color: #ffc107!important;
    }
    .cart-status-5{
        background-color: #28a745!important;
        color: #fff !important;
    }

</style>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>