@extends('layouts.vertical', ['title' => 'Freelancer Management'])

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
            {{-- <div class="row">
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
                </div> --
            </div> --}}
        </div>
    </div>

    {{-- Start of Project Requests --}}
    <div class="card  border-top  border-top-width-3 border-top-main  rounded-0 ">
        <div class="card-head p-2">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-activity text-brand-secondary "></i>Freelancers Management</h4>
            </div>

            <div class="btns">
                {{-- <a href="{{ route('flex.Users.create') }}" class="btn btn-main btn-sm float-end m-1" --}}
                <a href="{{ route('freelancer.create') }}" class="btn btn-secondary btn-sm float-end m-1" title="Add New User"
                {{-- data-bs-toggle="modal" --}}
                {{-- data-bs-target="#modal_add_user" --}}
                >
                    <i class="ph-plus me-2"></i> Freelancer
                </a>
                <a href="" class="btn btn-secondary btn-sm float-end m-1" title="Print Users">
                    <i class="ph-printer me-2"></i> Print
                </a>
            </div>
        </div>

        <div class="card-body ">
            <ul class="nav nav-tabs mb-3 px-2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#requests" class="nav-link active " data-bs-toggle="tab" aria-selected="true" role="tab"
                        tabindex="-1">
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

                {{-- For Going Users --}}
                <div class="tab-pane active show" id="ongoing-project" role="tabpanel">
                    <table class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th style="width: 10%;">Reg. Date</th>
                                <th>Full Name</th>
                                <th>User Code</th>
                                <th>Phone Number</th>
                                <th style="min-width: 250px; max-width: 280px;">Location</th>
                                <th style="width: 10%;">Email</th>
                                <th style="width: 11%;">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                foreach ($departments as $department) {
                                    if ($department->name == 'Sales') {
                                        $id = $department->id;
                                        $position_id = App\Models\Position::where('dept_id', $id)
                                                                          ->where('name', 'Freelancer')
                                                                          ->first();
                                        $freelancers = App\Models\User::where('position', $position_id->id)
                                                                      ->where('added_by', Auth::user()->id)
                                                                      ->get();
                                    }
                                }
                            @endphp

                            @foreach ($freelancers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $user->fname }} {{ $user->lname }}</td>
                                    <td>{{ $user->user_code }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->district->region->name ?? 'Dar es Salaam' }} - {{ $user->district->name ?? 'Ubungo' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <a href="{{route('freelancer.edit', $user->id)}}" class="btn btn-sm btn-primary edit-button">
                                           <i class="ph-note-pencil"></i>
                                        </a>
                                        @can('delete-user')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteRequest({{ $user->id }})">
                                            Delete
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
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
        function deleteRequest(id) {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'You are about to delete this freelancer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#006400', // Dark green
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!',
                customClass: {
                    confirmButton: 'my-confirm-btn'
                }}).then((result) => {
                if (result.isConfirmed) {

                    var terminationid = id;

                    $.ajax({
                            url: "/" + terminationid,
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Deleted !',
                                'Request is deleted Successifully!!.',
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Request Deletion Failed!! ....',
                                'error'
                            )
                        });
                }
            });
        }
    </script>
    <script>
        $(document).on('click', '.edit-button', function() {
            $('#edit-name').empty();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            $('#project_id').val(id);
            $('#id').val(id);
            $('#edit-name').append(name);
            $('#edit-description').val(description);
        });
    </script>

    {{-- For Approving --}}
    <script>
        $("#approve_form").submit(function(e) {
            $("#approve_yes").html("<i class='ph-spinner spinner me-2'></i> Approving")
                .addClass('disabled');
            $("#approve_no").hide();
        });
    </script>

    {{-- For Disapproving --}}
    <script>
        $("#disapprove_form").submit(function(e) {
            $("#disapprove_yes").html("<i class='ph-spinner spinner me-2'></i> Disapproving")
                .addClass('disabled');
            $("#disapprove_no").hide();
        });
    </script>
@endsection
