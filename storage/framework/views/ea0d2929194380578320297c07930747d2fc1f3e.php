    <div class="list-content-loading">
         <div class="half-circle-spinner">
             <div class="circle circle-1"></div>
             <div class="circle circle-2"></div>
         </div>
     </div>
    <div class="row">
        <div class="col-lg-6 mb-3">
            <label for="name" class="form-label"><?php echo e(__('Your name')); ?></label>
            <input required name="contact[name]" type="text" class="form-control" id="name">
        </div>
        <div class="col-lg-6 mb-3">
            <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
            <input name="contact[email]" type="email" class="form-control" id="email" placeholder="<?php echo e(__('Email')); ?> (không bắt buộc)">
        </div>
        <div class="col-lg-12 mb-3">
            <label for="phone" class="form-label"><?php echo e(__('Phone')); ?></label>
            <input name="contact[phone]" type="tel" class="form-control" id="phone" placeholder="<?php echo e(__('Phone')); ?> (không bắt buộc)">
        </div>
        <div class="col-lg-12 mb-3">
            <label for="subject" class="form-label"><?php echo e(__('Subject')); ?></label>
            <input required name="contact[subject]" type="text" class="form-control" id="subject">
        </div>
    </div>
    
    
    <div class="mb-3">
        <label for="messase" class="form-label"><?php echo e(__('Message')); ?> (không bắt buộc)</label>
        <textarea name="contact[message]" class="form-control" id="message" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="messase" class="form-label">Hình ảnh Toa thuốc (không bắt buộc)</label>
        <!-- Drag and drop file upload -->
        <div class="file-drop-area">
          <div class="file-drop-icon ci-cloud-upload"></div>
          <span class="file-drop-message">Kéo thả hình ảnh vào đây</span>
          <input type="file" class="file-drop-input">
          <button type="button" class="file-drop-btn btn btn-primary btn-active btn-radius btn-sm">Hoặc bấm chọn file</button>
        </div>
    </div>

    <?php if(isset($error) || isset($success)): ?>
    <div class="box-message mb-3">
        <p class="<?php echo e($error ? 'text-danger' : 'text-success'); ?>"><?php echo e(__($message)); ?></p>
    </div>
    <?php endif; ?><?php /**PATH C:\wamp64\www\expro\Laravel\nhathuockhanhkhoi\source-khanhkhoi\resources\views/theme/contact/contact_content.blade.php ENDPATH**/ ?>