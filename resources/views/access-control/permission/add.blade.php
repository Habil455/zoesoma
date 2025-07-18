<div class="modal fade" role="dialog" id="addPermissionModal" aria-labelledby="addPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            <form action="{{route('permissions.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
            @method('POST')
            <div class="modal-header p-2 px-2">
                <h5 class="modal-title">Add Permission</h5>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="">Module Name </label>
                    <select class="form-control m-b select" name="module_id" required>
                        <option value="" disabled selected>Choose option</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->slug}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="">Permission Tag </label>
                    <input type="text" class="form-control" name="slug" required>
                </div>
            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                   <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                   <button class="btn btn-secondary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
