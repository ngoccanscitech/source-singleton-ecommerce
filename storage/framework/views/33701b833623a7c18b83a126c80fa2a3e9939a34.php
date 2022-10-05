<?php $status = $status ?? 1;  ?>
<div class="card">
    <div class="card-header">
        <h5>Publish</h5>
    </div> <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <input type="radio" id="radioDraft" name="status" value="0" <?php echo e($status == 0 ? 'checked' : ''); ?>>
                <label for="radioDraft">Draft</label>
            </div>
            <div class="icheck-primary d-inline" style="margin-left: 15px;">
                <input type="radio" id="radioPublic" name="status" value="1" <?php echo e($status == 1 ? 'checked' : ''); ?> >
                <label for="radioPublic">Public</label>
            </div>
        </div>
        
        <div class="form-group text-right">
            <button type="submit" name="submit" value="save" class="btn btn-info">Save</button>
            <button type="submit" name="submit" value="apply" class="btn btn-success">Save & Edit</button>
        </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->
<?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/admin/partials/action_button.blade.php ENDPATH**/ ?>