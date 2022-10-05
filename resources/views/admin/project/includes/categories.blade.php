@if(count($categories)>0)
    <div class="card widget-category">
        <div class="card-header">
            <h3>Thể loại</h3>
        </div> <!-- /.card-header -->
        <div class="card-body">
            @if(count($categories)>0)
                @include('admin.project.includes.category-item', ['data'=>$categories, 'id_selected'=>$id_selected])
            @endif
        </div> <!-- /.card-body -->
    </div><!-- /.card -->
@endif