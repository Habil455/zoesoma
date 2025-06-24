@extends('layouts.vertical', ['title' => 'User Management'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-0  border-top  border-top-width-3 border-top-main  rounded-0 d-md-block d-none">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-sm-4">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                            <i class="ph-list"></i>
                        </a>
                        <div class="text-center">
                            <div class="fw-semibold">Total Users</div>
                            <span class="text-muted"></span>
                        </div>
                    </div>
                    <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="bg-success bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
                            <i class="ph-download"></i>
                        </a>
                        <div class="text-center">
                            <div class="fw-semibold">Inactive Users</div>
                            <span class="text-muted"></span>
                        </div>
                    </div>
                    <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                </div>

                <div class="col-sm-4">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                            <i class="ph-clock"></i>
                        </a>
                        <div class="text-center">
                            <div class="fw-semibold">Active Users</div>
                            <span class="text-muted"></span>
                        </div>
                    </div>
                    <div class="w-75 mx-auto mb-3" id="total-online"></div>
                </div>


                {{-- <div class="col-sm-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                            <i class="ph-check"></i>
                        </a>
                        <div class="text-center">
                            <div class="fw-semibold">Completed Users</div>
                            <span class="text-muted"></span>
                        </div>
                    </div>
                    <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- Start of Project Requests --}}
    <div class="card  border-top  border-top-width-3 border-top-main  rounded-0 ">
        <div class="card-head p-2">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-activity text-brand-secondary "></i>Users Management</h4>
            </div>

            <div class="btns">
                <a href="{{ route('user.create') }}" class="btn btn-secondary btn-sm float-end m-1" title="Add New User">
                    <i class="ph-plus me-2"></i> Add User
                </a>
                <a href="" class="btn btn-secondary btn-sm float-end m-1" title="Print Users">
                    <i class="ph-printer me-2"></i> Print Users
                </a>
                <a href="{{ route('users.resend_credentials', ['option' => 'all', 'id' => 0]) }}" class="btn btn-secondary btn-sm float-end m-1" title="Print Users">
                    <i class="ph ph-paper-plane me-2"></i> Resend Credentials
                </a>
            </div>
        </div>

        <div class="card-body ">
            <ul class="nav nav-tabs mb-3 px-2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#requests" class="nav-link active " data-bs-toggle="tab" aria-selected="true" role="tab"
                        tabindex="-1">
                        All Staffs
                        <span class="badge bg-dark text-brand-secondary rounded-pill ms-2"></span>
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#ongoing-project" class="nav-link " data-bs-toggle="tab" aria-selected="false" role="tab">
                        Freelancers
                        <span class="badge bg-dark text-brand-secondary rounded-pill ms-2"></span>
                    </a>
                </li>

                {{-- <li class="nav-item" role="presentation">
                    <a href="#completed" class="nav-link " data-bs-toggle="tab" aria-selected="false" role="tab">
                        Inactive Users
                        <span class="badge bg-dark text-brand-secondary rounded-pill ms-2"></span>
                    </a>
                </li> --}}
            </ul>

            <div class="tab-content">
                {{-- For Goingload Requests --}}
                <div class="tab-pane fade active show" id="requests" role="tabpanel">
                    <table id="" class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>User Code </th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Registered By</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @foreach ($staffs as $user)
                            @php
                                $register = App\Models\User::where('id', $user->added_by)->first();
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->fname }} {{ $user->lname }}</td>
                                    <td>{{ $user->user_code }}</td>
                                    <td>{{ $user->phone }}</td>
                                    {{-- {{dd($user->district)}} --}}
                                    <td>{{ $user->district->region->name ?? 'Dar es Salaam' }} -
                                        {{ $user->district->name ?? 'Ubungo' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $register->fname ?? 'Null' }} {{ $register->lname ?? 'Null' }}</td>
                                </td>
                                    {{-- <td>
                                        @if ($user->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <a href="{{ route('freelancer.edit', $user->id) }}"
                                            class="btn btn-sm btn-primary edit-button">
                                            <i class="ph-note-pencil"></i>
                                        </a>
                                        @can('delete-user')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteUser({{ $user->id }})">
                                                Delete
                                            </button>
                                        @endcan
                                        @can('resend-credentials')
                                        <a title="Resend Credentials" href="{{ route('single_user.resend_credentials',['option' => 'single', 'id' => $user->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ph ph-paper-plane me-2"></i>
                                        </a>
                                    @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- ./ --}}

                {{-- For Going Users --}}
                <div class="tab-pane fade  show" id="ongoing-project" role="tabpanel">
                    <table id="" class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>User Code </th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Email</th>
                            <th>Registered By</th>
                            <th>Options</th>
                        </thead>
                        @foreach ($freelancers as $user)
                            @php
                                $register = App\Models\User::where('id', $user->added_by)->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->fname }} {{ $user->lname }}</td>
                                <td>{{ $user->user_code }}</td>
                                <td>{{ $user->phone }}</td>
                                {{-- {{dd($user->district)}} --}}
                                <td>{{ $user->district->region->name ?? 'Dar es Salaam' }} -
                                    {{ $user->district->name ?? 'Ubungo' }}</td>
                                <td>{{ $user->email }}</td>

                                <td>{{ $register->fname ?? 'Null' }} {{ $register->lname ?? 'Null' }}</td>
                                </td>
                                <td>
                                    <a href="{{ route('freelancer.edit', $user->id) }}"
                                        class="btn btn-sm btn-primary edit-button">
                                        <i class="ph-note-pencil"></i>
                                    </a>
                                    @can('delete-user')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteUser({{ $user->id }})">
                                            Delete
                                        </button>
                                    @endcan

                                    @can('resend-credentials')
                                        <a title="Resend Credentials" href="{{ route('single_user.resend_credentials',['option' => 'single', 'id' => $user->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="ph ph-paper-plane me-2"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- ./ --}}

                {{-- For Completed Users --}}
                <div class="tab-pane fade  show" id="completed" role="tabpanel">
                    <table id="" class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Project Number</th>
                            <th>Revenue</th>
                            <th>Status</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 10; $i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ now()->subDays($i)->format('d/m/Y') }}</td>
                                    <td>PN{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ number_format(rand(10000, 50000), 2) }}</td>
                                    <td>Completed</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                {{-- ./ --}}

            </div>
        </div>
        {{-- / --}}
    </div>
    {{-- ./ --}}
    {{-- @include('user.create') --}}


    {{-- start of Project Request approval  modal --}}
    <div id="approval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-danger " data-bs-dismiss="modal"></button>
                </div>

                <modal-body class="p-4">
                    <h6 class="text-center">Are you sure you want to Approve this request?</h6>

                    {{-- <form action="{{ route('flex.projects.approveProject') }}" id="approve_form" method="post"> --}}
                    <form action="" id="approve_form" method="post">
                        @csrf
                        <input name="project_id" id="project_id" type="hidden">

                        <div class="row mb-2">
                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="reason" required placeholder="Please Enter Remarks Here" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-4 mx-auto">
                                <button type="submit" id="approve_yes" class="btn btn-main btn-sm px-4 ">Yes</button>
                                <button type="button" id="approve_no" class="btn btn-danger btn-sm  px-4 text-light"
                                    data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </modal-body>
                <modal-footer></modal-footer>
            </div>
        </div>
    </div>
    {{-- end of approval modal --}}

    {{-- start of disapproval  modal --}}
    <div id="disapproval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-danger " data-bs-dismiss="modal"></button>
                </div>

                <modal-body class="p-4">
                    <h6 class="text-center">Are you sure you want to Disapprove this request?</h6>

                    <form action="" id="disapprove_form" method="post">
                        @csrf
                        <input name="project_id" id="id" type="hidden">

                        <div class="row mb-2">
                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="reason" required placeholder="Please Enter Remarks Here" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-4 mx-auto">
                                <button type="submit" id="disapprove_yes" class="btn btn-main btn-sm px-4 ">Yes</button>
                                <button type="button" id="disapprove_no" class="btn btn-danger btn-sm  px-4 text-light"
                                    data-bs-dismiss="modal">
                                    No
                                </button>
                            </div>
                        </div>
                    </form>
                </modal-body>

                <modal-footer></modal-footer>
            </div>
        </div>
    </div>
    {{-- end of disapproval modal --}}


    <script>
        function deleteUser(id) {
            Swal.fire({
                text: 'Are You Sure You Want to Delete This User ?',
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
                            url: "{{ route('user.destroy', ':id') }}".replace(':id', customer_id),
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
                                'User was Deleted Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'User Deletion Failed!! ....',
                                'success'
                            )
                        });
                }
            });
        }
    </script>
@endsection
