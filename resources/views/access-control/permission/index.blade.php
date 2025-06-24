
@extends('layouts.vertical', ['title' => 'Permissions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
    <div class="card-header border-0">
        <h5 class="mb-0 text-warning">Permissions</h5>
        <div class="header-elements">
            <button type="button" class="btn btn-secondary float-end" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                <i class="ph-plus me-2"></i>Add Permission
            </button>
        </div>
    </div>


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th style="width: 5%;">S/N</th>
                <th style="width: 40%;">Slug</th>
                <th style="width: 40%;">Module</th>
                <th hidden></th>
                <th hidden></th>
                <th style="max-width: 15%">Options</th>
            </tr>
        </thead>

        <tbody>
            @if(isset($permissions))
                @foreach($permissions as $permission)


                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $permission->slug }}</td>
                            <td>{{ $permission->modules->slug  ?? '' }}</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary edit-button" data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                    data-id="{{ $permission->id }}"
                                    data-slug="{{ $permission->slug }}"
                                    data-module_id="{{ $permission->module_id }}"
                                    >
                                    <i class="ph-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-button" 
                                    onclick="deletePermission({{$permission->id}})">
                                    <i class="ph-trash"></i>
                            </button>
                            </td>
                        </tr>

                @endforeach
            @endif
        </tbody>
    </table>
</div>
@include('access-control.permission.add')

<script>
    function deletePermission(id) {
        Swal.fire({
            text: 'Are You Sure You Want to Delete This Permission ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,Delete !'
        }).then((result) => {
            if (result.isConfirmed) {
                var customer_id = id;
                // console.log(customer_id);


                $.ajax({
                        url: "{{ route('permissions.destroy', ':id') }}".replace(':id', customer_id),
                        type: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">DELETED</span></div>'
                            );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Deleted !',
                            'Permission was Deleted Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Permission Deletion Failed!! ....',
                            'success'
                        )
                    });
            }
        });
    }
</script>
@endsection



