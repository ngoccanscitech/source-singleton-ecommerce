@php $status = $status ?? 1;  @endphp
<div class="card">
    <div class="card-header">
        <h5>Publish</h5>
    </div> <!-- /.card-header -->
    <div class="card-body">
        <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
                <input type="radio" id="radioDraft" name="status" value="0" {{ $status == 0 ? 'checked' : ''  }}>
                <label for="radioDraft">Draft</label>
            </div>
            <div class="icheck-primary d-inline" style="margin-left: 15px;">
                <input type="radio" id="radioPublic" name="status" value="1" {{ $status == 1 ? 'checked' : ''  }} >
                <label for="radioPublic">Public</label>
            </div>
        </div>
        {{--
        <div class="form-group">
            <label>Date:</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                <input type="text" name="created" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $date_update ?? '' }}">
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        --}}
        <div class="form-group text-right">
            <button type="submit" name="submit" value="save" class="btn btn-info">Save</button>
            <button type="submit" name="submit" value="apply" class="btn btn-success">Save & Edit</button>
        </div>
    </div> <!-- /.card-body -->
</div><!-- /.card -->
