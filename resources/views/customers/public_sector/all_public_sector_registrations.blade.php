{{-- This is all Customer Page --}}

@extends('layouts.vertical', ['title' => 'All Clients'])

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
                <h4 class="lead "> <i class="ph-users-four text-brand-secondary "></i> All Public Sector Customers </h4>

                {{-- @can('add-customer') --}}
                    <a href="{{ route('public.customer.create') }}" class="btn btn-secondary btn-sm">

                        <i class="ph-plus me-2"></i> Public Sector</a>
                    </button>
                {{-- @endcan --}}
            </div>
        </div>

        @if (session('msg'))
            <div class="alert alert-success mt-1 mb-1 col-10 mx-auto" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        <table class="table table-striped table-bordered datatable-basic">
            <thead>
                <th>No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th style="width: 15%">Location</th>
                <th >Registered By</th>
                <th style="width: 20%">Date</th>
                <th style="width: 16%">Options</th>
            </thead>

            <tbody>
                @foreach ($all_customers as $customer)
                @php
                    $registered_by = App\Models\User::where('id', $customer->created_by)->first();
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <b>{{$customer->first_name}} {{$customer->last_name}}</b> <br />
                    </td>
                    <td>{{$customer->phone_number}}</td>
                    <td>{{$customer->region->name}}</td>
                    <td>{{$registered_by->fname}} {{$registered_by->lname}}</td>
                    <td>{{ $customer->created_at->format('d-M-Y') }}</td>
                    <td>
                        <a href="{{ route('customer.show', $customer->id) }}" title="View Info"
                            class="btn btn-sm btn-secondary edit-button enabled">
                            <i class="ph ph-info"></i>
                        </a>
                        {{-- <a href="#" class="btn btn-sm btn-primary edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit_user" data-id="{{ $customer->id }}"
                            data-name="{{ $customer->name }}" data-description="{{ $customer->description }}">
                            Edit
                        </a> --}}

                        @can('delete-customer')
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="deleteCustomer({{ $customer->id }})">
                            Delete
                        </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function deleteCustomer(id) {
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
                    var customer_id = id;
                    // console.log(customer_id);


                    $.ajax({
                            url: "{{ route('customer.destroy', ':id') }}".replace(':id', customer_id),
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
