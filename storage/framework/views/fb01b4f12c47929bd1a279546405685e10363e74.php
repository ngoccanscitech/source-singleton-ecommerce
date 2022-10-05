<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
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
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Product</li>
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
		            	<h3>Product</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="<?php echo e(route('admin.createProduct')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\ShopCategory::where('parent', 0)->orderBy('id', 'ASC')
                                                ->select('id', 'name')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category_id">
                                        <option value="">Danh mục</option>
                                        <?php $__currentLoopData = $list_cate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cate->id); ?>" <?php echo e(request('category_id') == $cate->id ? 'selected': ''); ?>><?php echo e($cate->name); ?></option>
                                            <?php if(count($cate->children)>0): ?>
                                                <?php $__currentLoopData = $cate->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate_child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cate_child->id); ?>" <?php echo e(request('category_id') == $cate_child->id ? 'selected': ''); ?>>   &ensp;&ensp;<?php echo e($cate_child->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Tìm kiếm SP" value="<?php echo e(request('search_title')); ?>">
                                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fl" style="font-size: 17px;">
                                <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;"><?php echo e($total_item); ?></span> sản phẩm
                            </div>
                            <div class="fr">
                                <?php echo $data_product->links(); ?>

                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" width="100" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Tên sản phẩm</th>
                                        <th scope="col" class="text-center">Danh mục</th>
                                        <th scope="col" class="text-center">Hình ảnh</th>
                                        <th scope="col" class="text-center">Ngày và trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
                                        <td>
                                            <a class="row-title" href="<?php echo e(route('admin.productDetail', array($data->id))); ?>">
                                                <b><?php echo e($data->name); ?></b>           
                                            </a>
                                        </td>
                                        <td>
                                            <?php
                                                $categories = $data->categories;
                                                //dd($category);
                                            ?>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($k>0 ? ',':''); ?> <a class="tag" target="_blank" href="#"><?php echo e($category->name); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($data->image != ''): ?>
                                                <img src="<?php echo e(asset($data->image)); ?>" style="height: 50px;">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e(date('d/m/Y', strtotime($data->expiry))); ?>

                                            <br>
                                            <?php if($data->status == 1): ?>
                                                <span class="badge badge-primary">Public</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Draft</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $data_product->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/product/index.blade.php ENDPATH**/ ?>