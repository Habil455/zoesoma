{{-- This is all Customer Page --}}

@extends('layouts.vertical', ['title' => 'All Departments'])

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
                <h4 class="lead "> <i class="ph-users-four text-brand-secondary "></i> All Departments </h4>

                {{-- @can('add-customer') --}}
                    {{-- <a href="{{ route('flex.add-customer') }}" class="btn btn-main btn-sm"> --}}
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal_add_department">
                        <i class="ph-plus me-2"></i> Add Department
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
        
                @forelse ($departments as $department)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $department->name }}</td>
                        <td>
                            @if ($department->status == 1)
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
                            <form action="{{ route('department.destroy', $department->id) }}" method="POST" style="display:inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this department?');">
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
                        <td colspan="4" class="text-center">No departments available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
            {{-- <tbody>
                @foreach ($customers as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <b>{{ $item->company }}</b> <br />
                            <small>{{ $item->contact_person }}</small>
                        </td>
                        <td>
                            @php
                                $amount = 0;
                                $amount1 = 0;
                                $amount2 = 0;
                                $ledger = App\Models\Account\LedgerAccount::where('customer_id', $item->id)->first();
                                $amount1 = App\Models\Account\Transaction::where('ledger_id', $ledger->id)
                                    ->where('type', 1)
                                    ->sum('amount');
                                $amount2 = App\Models\Account\Transaction::where('ledger_id', $ledger->id)
                                    ->where('type', 2)
                                    ->sum('amount');
                                $projects = App\Models\Project::where('customer_id', $item->id)->count();

                                $amount = $amount2 - $amount1;
                            @endphp

                            {{ 'Tsh ' . number_format($amount, 2) }}
                        </td>
                        <td>{{ $item->abbreviation }}</td>
                        {{-- <td hidden>{{ $item->email }} </td>
                        <td width="18%">{{ $item->phone }} </td>
                        {{-- <td>{{ $item->address }} </td> -
                        <td width="20%">
                            @can('view-customer')
                                <a href="{{ route('flex.project-customer-details', $item->id) }}" class="btn btn-sm btn-main">
                                    <i class="ph-info"></i>
                                </a>
                            @endcan

                            @can('edit-customer')
                                <a href="{{ url('/customers/edit-customer/' . $item->id) }}" class="btn btn-sm btn-main">
                                    <i class="ph-note-pencil"></i>
                                </a>
                            @endcan

                            @can('delete-customer')
                                @if ($projects == 0)
                                    <a href="javascript:void(0)" title="Cancel"
                                        class="icon-2 info-tooltip btn btn-danger btn-sm"
                                        onclick="cancelAllocation(<?php echo $item->id; ?>)">
                                        <i class="ph-trash"></i>
                                    </a>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>

    @include('department.add-department')
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
