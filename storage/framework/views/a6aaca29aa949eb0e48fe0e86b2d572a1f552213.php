
<?php
if(isset($data)){
    $data = $data->toArray();
    extract($data);
    

    $title_head = $name;
}
?>
<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => $title_head.' | '.Helpers::get_option_minhnn('seo-title-add')
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
        <form action="<?php echo e(route('admin.email_template.post')); ?>" method="POST" id="frm-create-post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo e($id ?? 0); ?>">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4><?php echo e($title_head); ?></h4>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="title" name="title" placeholder="Tiêu đề" value="<?php echo e($name ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <select class="form-control group select2" style="width: 100%;" name="group" >
                                        <option value="">Chọn group</option>
                                        <?php $__currentLoopData = $arrayGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($k); ?>" <?php echo e(isset($group) && $group ==$k ? 'selected':''); ?>><?php echo e($v); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="price" class="title_txt">Nội dung</label>
                                    <div class="input-group mb-3">
                                        <textarea name="content" id="text"><?php echo isset($text) ? htmlspecialchars_decode($text) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <?php echo $__env->make('admin.partials.action_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<!-- Create a simple CodeMirror instance -->
<link rel="stylesheet" href="<?php echo e(asset('assets/mirror/lib/codemirror.css')); ?>">
    <style type="text/css">
        .select2-container .select2-selection--single{
            height: auto;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>


<script src="<?php echo e(asset('assets/mirror/lib/codemirror.js')); ?>"></script>
<script src="<?php echo e(asset('assets/mirror/mode/javascript/javascript.js')); ?>"></script>
<script src="<?php echo e(asset('assets/mirror/mode/css/css.js')); ?>"></script>
<script src="<?php echo e(asset('assets/mirror/mode/htmlmixed/htmlmixed.js')); ?>"></script>

<script>
    window.onload = function() {
      editor = CodeMirror(document.getElementById("text"), {
        mode: "text/html",
        value: document.documentElement.innerHTML
      });
    };
    var myModeSpec = {
    name: "htmlmixed",
    tags: {
        style: [["type", /^text\/(x-)?scss$/, "text/x-scss"],
                [null, null, "css"]],
        custom: [[null, null, "customMode"]]
    }
    }
    var editor = CodeMirror.fromTextArea(document.getElementById("text"), {
      lineNumbers: true,
      styleActiveLine: true,
      matchBrackets: true
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/email_template/single.blade.php ENDPATH**/ ?>