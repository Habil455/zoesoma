{{-- This is all Customer Page --}}

@extends('layouts.vertical', ['title' => 'All identifications'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-main  rounded-0">
        <div class="card-body ">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-users-four text-brand-secondary "></i> Identification Types </h4>

                {{-- @can('add-customer') --}}
                    {{-- <a href="{{ route('flex.add-customer') }}" class="btn btn-main btn-sm"> --}}
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal_add_identification">
                        <i class="ph-plus me-2"></i> Add Type
                    </button>
                {{-- @endcan --}}
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-1 mb-1 col-10 mx-auto" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped table-responsive table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>

            <tbody>
                @php $i = 1; @endphp

                @forelse ($ids as $identification)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $identification->name }}</td>
                        <td>
                            @if ($identification->status == 1)
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            @else
                                <span class="badge bg-info bg-opacity-10 text-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            {{-- Edit Button --}}
                            <button type="button" class="btn btn-main btn-sm editSupplier" data-bs-toggle="modal" data-bs-target="#modal_edit_supplier">
                                <i class="ph-note-pencil"></i>
                            </button>

                            {{-- Delete Button --}}
                            <form action="{{ route('identification.destroy', $identification->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this identification?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="ph-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Identifications available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </table>
    </div>

    @include('identifications.add-identification')
    <script>
        function cancelAllocation(id) {
            Swal.fire({
                text: 'Are You Sure You Want to Delete This Customer ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,Delete !'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url: "" + terminationid
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
                                'Customer was Deleted Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Customer Deletion Failed!! ....',
                                'success'
                            )
                        });
                }
            });
        }
    </script>
@endsection
