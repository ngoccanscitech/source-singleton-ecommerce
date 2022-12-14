<?php
if(isset($product_detail)){
    $product_info = $product_detail->getInfo;
    $getPackage = $product_detail->getPackage;
    if($product_info != '')
        extract($product_info->toArray());

    extract($product_detail->toArray());
    
    $gallery = (isset($gallery) || $gallery != "") ? unserialize($gallery) : '';
    
    

} else{
    $title_head = 'Add new product';
}
    $id = $id ?? 0;
    $date_update = $updated_at??'';

    $title_head = $name ??'';
    $unit = $unit??'';

    $spec_short = $spec_short??'';


    $variables_check = \App\Model\Variable::where('status', 0)->where('parent', 0)->count();
    
    // dd($listClass);
?>
<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => $title_head .' | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => $title_head.' | '.Helpers::get_option_minhnn('seo-title-add'),
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
          <li class="breadcrumb-item active"><?php echo e($title_head); ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="<?php echo e(route('admin.postProductDetail')); ?>" method="POST" id="frm-create-product" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo e($id ?? 0); ?>">
            <?php echo csrf_field(); ?>
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3><?php echo e($title_head); ?></h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control title_slugify" id="title" name="name" placeholder="Ti??u ?????" value="<?php echo e($name ?? ''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="<?php echo e($slug ?? ''); ?>">
                                    </div>
                                    <?php echo $__env->make('admin.partials.quote', ['description'=> $description ?? '' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('admin.partials.content', ['content'=> $content ?? '' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>

                            </div>
                            
                            
                            
                            
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->

                    <div class="card">
                        <div class="card-header">Gi?? v?? kho</div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="price" class="title_txt col-form-label col-md-4">Gi??</label>
                                        <div class="col-md-8">
                                            <input type="text" name="price" id="price" value="<?php echo e($price ?? ''); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="unit" class="title_txt col-form-label col-md-4">????n v??? t??nh</label>
                                        <div class="col-md-8">
                                            
                                            <input type="text" name="unit" id="unit" value="<?php echo e($unit ?? ''); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Gi?? khuy???n m??i</label>
                                    <div class="col-md-8">
                                        <input type="text" name="promotion" id="promotion" value="<?php echo e($promotion ?? ''); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ng??y b???t ?????u</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_start" id="date_start" value="<?php echo e($date_start ?? ''); ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ng??y k???t th??c</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_end" id="date_end" value="<?php echo e($date_end ?? ''); ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="price" class="title_txt">Kho</label>
                                    <input type="text" name="stock" id="stock" value="<?php echo e($stock ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="sku" class="title_txt">Sku</label>
                                    <input type="text" name="sku" id="sku" value="<?php echo e($sku ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="stt" class="title_txt">S???p x???p</label>
                                    <input type="text" name="stt" id="stt" value="<?php echo e($stt ?? ''); ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Gallery</div> <!-- /.card-header -->
                        <div class="card-body">
                            <!--********************************************Gallery**************************************************-->
                            <!--Post Gallery-->
                            <div class="form-group">
                                <?php echo $__env->make('admin.partials.galleries', ['gallery_images'=> $gallery ?? ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <!--End Post Gallery-->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Th??nh ph???n</div> <!-- /.card-header -->
                            <div class="card-body">
                                <?php echo $__env->make('admin.product.includes.spec-short', compact('spec_short'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                    </div>

                    <?php if($variables_check): ?>
                    <div class="card">
                        <div class="card-header">Variable</div> <!-- /.card-header -->
                        <div class="card-body">
                            <?php if(isset($id) && $id > 0): ?>
                                <!-- variable -->
                                <?php echo $__env->make('admin.product.includes.variables', ['product_id' => $id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <!-- variable -->
                            <?php else: ?>
                                <p style="color: red;">Please click save product to use this function</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">SEO</div> <!-- /.card-header -->
                        <div class="card-body">
                            <!--SEO-->
                            <?php echo $__env->make('admin.form-seo.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <?php echo $__env->make('admin.partials.action_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="card widget-category">
                        <div class="card-header">
                            <h4>Category</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $data_checks=App\Model\ShopProductCategory::where('product_id', $id)->get();
                                    $array_checked=array();
                                    if($data_checks):
                                        foreach($data_checks as $data_check):
                                            array_push($array_checked, $data_check->category_id);
                                        endforeach;
                                    endif;
                                    $categories = App\Model\ShopCategory::where('parent', 0)->orderBy('priority','DESC')->get();
                                    ?>
                                    <?php echo $__env->make('admin.product.includes.category-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                    <div class="card widget-category">
                        <div class="card-header">
                            <h4>Th????ng hi???u</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $data_checks = App\Model\ShopProductBrand::where('product_id', $id)->get();
                                    $array_checked = [];
                                    if($data_checks)
                                        foreach($data_checks as $data_check){
                                            array_push($array_checked, $data_check->brand_id);
                                        }
                                    
                                    $brands = App\Model\ShopBrand::where('status', 1)->orderBy('sort','DESC')->get();
                                    ?>
                                    <ul id="muti_menu_post" class="muti_menu_right_category">
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $checked = '';
                                            if(in_array($brand->id, $array_checked))
                                                $checked = 'checked';
                                        ?>
                                        <li class="category_menu_list">
                                            <label for="checkbox_br_<?php echo e($brand->id); ?>" class="font-weight-normal">
                                                <input type="checkbox" class="category_item_input" name="brand_item[]" value="<?php echo e($brand->id); ?>" id="checkbox_br_<?php echo e($brand->id); ?>" <?php echo e($checked); ?>>
                                                <span><?php echo e($brand->name); ?></span>
                                            </label>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                    <div class="card widget-category">
                        <div class="card-header">
                            <h4>Th??nh ph???n</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $elements_checks = App\Model\ShopProductElement::where('product_id', $id)->get();
                                    $elements_check = [];
                                    if($elements_checks)
                                        foreach($elements_checks as $data_check){
                                            array_push($elements_check, $data_check->element_id);
                                        }
                                    
                                    $elements = App\Model\ShopElement::where('status', 1)->orderBy('sort','DESC')->get();
                                    ?>
                                    <ul id="muti_menu_post" class="muti_menu_right_category">
                                        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $checked = '';
                                            if(in_array($item->id, $elements_check))
                                                $checked = 'checked';
                                        ?>
                                        <li class="category_menu_list">
                                            <label for="checkbox_el_<?php echo e($item->id); ?>" class="font-weight-normal">
                                                <input type="checkbox" class="category_item_input" name="element_item[]" value="<?php echo e($item->id); ?>" id="checkbox_el_<?php echo e($item->id); ?>" <?php echo e($checked); ?>>
                                                <span><?php echo e($item->name); ?></span>
                                            </label>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                    <?php echo $__env->make('admin.partials.image', ['title'=>'Image', 'id'=>'img', 'name'=>'image', 'image'=>$image??''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('admin.partials.image', ['title'=>'H??nh ???nh Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=> ($cover ?? '')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>

<?php $__env->startPush('styles'); ?>
<!-- add styles here -->
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts-footer'); ?>
<!-- add script here -->
<?php $__env->stopPush(); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/js/datetimepicker/jquery.datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('assets/js/datetimepicker/jquery.datetimepicker.full.min.js')); ?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('.slug_slugify').slugify('.title_slugify');
        $('#js-variable-products-select').select2();
        //Date range picker
        $('#date_start').datetimepicker({
            minDate:0,
            format:'Y-m-d H:i'
        });
        $('#date_end').datetimepicker({
            minDate:0,
            format:'Y-m-d H:i'
        });
        

        //x??? l?? validate
        $("#frm-create-product").validate({
            rules: {
                title: "required",
                'category_item[]': { required: true, minlength: 1 },
                price: "required",
                weight: {
                    required:true
                },
            },
            messages: {
                title: "Enter title",
                'category_item[]': "Select category",
                price: "Enter price",
                weight: {
                    required:"Enter weight"
                },
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });

        
        // auto check parrent
        $('#muti_menu_post input').each(function(index, el) {
            if($(this).is(':checked')){
                console.log($(this).val());
                $(this).closest('.sub-menu').parent().find('label').first().find('input').prop('checked', true);
            }
        });
    });
</script>
<script type="text/javascript">
    editor('content');
    editorQuote('description');
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/product/single.blade.php ENDPATH**/ ?>