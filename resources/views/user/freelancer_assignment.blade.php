{{-- This is all trucks Page --}}
@extends('layouts.vertical', ['title' => 'Supervisor Assignment'])
@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush


@section('content')

    <div class="card  border-top  border-top-width-3 border-top-black rounded-0">

        <div class="mt-2">


            {{-- Assign Supervisor button --}}
            {{-- @can('assign-Supervisor') --}}
            <a href="" class="btn btn btn-secondary btn-sm float-end mx-1" data-bs-toggle="modal"
                title="Assign Supervisor" data-bs-target="#approval">
                <i class="ph-user me-2"></i> Freelancer
            </a>
            {{-- @endcan --}}
            {{-- / --}}
            {{-- <a href="{{ route('flex.print-trucks') }}" class="btn btn-main btn-sm float-end" title="Add New Truck">
                <i class="ph-printer me-2"></i> Print Trucks
            </a> --}}

            {{-- <a href="" class="btn btn-secondary btn-sm float-end" title="Add New Truck">
                <i class="ph-printer me-2"></i> Print Assignments
            </a>
            <h4 class="lead text-black d-none d-sm-block ">Freelancers</h4> --}}


        </div>
        {{-- <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <form action="{{ route('trucks.import') }}" method="POST" enctype="multipart/form-data"
                        style="margin-top:20px;">
                        @csrf
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="file" name="file" class="form-control" accept=".xlsx, .csv" required>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-main  btn-block"> <i class="ph ph-download"></i>
                                    &nbsp; Import Trucks</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('trucks.exportTemplate') }}" class="btn btn-success mt-3">Download Template</a>
                </div>
            </div>
        </div> --}}
        <div class="card-body ">

            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#js-tab1" class="nav-link active " data-bs-toggle="tab" aria-selected="true" role="tab"
                        tabindex="-1">
                        Supervisors
                    </a>
                </li>

            </ul>
            <div class="tab-content">
                {{-- For Active Trucks --}}
                <div class="tab-pane fade active show" id="js-tab1" role="tabpanel">
                    {{-- For Alert Messages --}}
                    @if (session('msg'))
                        <div class="alert alert-success mt-1 mb-1 col-10 mx-auto" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif
                    {{-- / --}}
                    {{-- For All trucks Table --}}
                    {{-- @can('view-trucks') --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <th style="width: 5%;">No.</th>
                                <th style="width: 25%;">Supervisor Name</th>
                                <th style="width: 25%;">Location</th>
                                <th style="width: 20%;">Total Freelancers</th>
                                <th style="width: 10%;" hidden>Status</th>
                                <th style="width: 15%;">Options</th>
                            </thead>

                            <tbody>
                               @forelse ($staffs as $staff)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staff->fname }} {{ $staff->lname }}</td>
                                    <td>{{ $staff->district->name ?? 'Not Available'  }}</td>
                                    <td>
                                        @php
                                        $staff_id = $staff->id;
                                        $total_freelancers = App\Models\User::whereHas('positions', function($query) use ($staff_id) {
                                            $query->where('name', 'Freelancer')
                                                ->where('added_by', $staff_id);
                                        })->count();
                                    @endphp
                                        {{ $total_freelancers }}
                                    </td>
                                    <td hidden></td>
                                    {{-- <td> --}}
                                        {{-- @if ($user->status == 1) --}}
                                            {{-- <span class="badge bg-success">Active</span> --}}
                                        {{-- @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif --}}
                                    {{-- </td> --}}
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary edit-button" data-bs-toggle="modal"
                                            data-bs-target="#edit_user" data-id="{{ $staff->id }}"
                                            data-name="{{ $staff->name }}" data-description="{{ $staff->description }}">
                                            View
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteRequest({{ $staff->id }})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Assignments available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- @endcan --}}
                    {{-- / --}}
                </div>
                {{-- ./ --}}

                {{-- For Private Trucks --}}
                <div class="tab-pane fade " id="js-tab3" role="tabpanel">
                    {{-- start of deactivated Trucks --}}
                    {{-- @can('view-deactivated-trucks') --}}
                    <div class="">
                        {{-- For Larger screens --}}
                        <h4 class="lead text-black d-none d-sm-block "> <i class="ph-truck text-brand-secondary"></i>
                            Private
                            Trucks
                        </h4>
                        {{-- / --}}
                        {{-- For small Screens --}}
                        <p class="lead text-black d-sm-none d-block ">
                            <small>
                                <i class="ph-truck text-brand-secondary"></i>
                                Private Trucks
                            </small>
                        </p>
                        {{-- / --}}
                    </div>

                    {{-- For Alert Messages --}}
                    @if (session('msg1'))
                        <div class="alert alert-danger mt-1 mb-1 col-10 mx-auto" role="alert">
                            {{ session('msg1') }}
                        </div>
                    @endif
                    {{-- / --}}
                    {{-- For All trucks Table --}}
                    {{-- @can('view-trucks') --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <th>No.</th>
                                <th>Registration Number</th>
                                <th>Model</th>
                                <th> Type</th>
                                <th hidden>Last Location</th>
                                <th>Status</th>
                                <th>Options</th>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    {{-- @endcan --}}
                    {{-- / --}}

                    {{-- @endcan --}}
                    {{-- ./ --}}
                </div>
                {{-- ./ --}}


                {{-- For Deactivated Trucks --}}
                <div class="tab-pane fade " id="js-tab2" role="tabpanel">

                    {{-- start of deactivated Trucks --}}
                    @can('view-deactivated-trucks')
                        <div class="">
                            {{-- For Larger screens --}}
                            <h4 class="lead text-black d-none d-sm-block "> <i class="ph-truck text-brand-secondary"></i>
                                Deactivated
                                Trucks
                            </h4>
                            {{-- / --}}
                            {{-- For small Screens --}}
                            <p class="lead text-black d-sm-none d-block "><small> <i class="ph-truck text-brand-secondary"></i>
                                    Deactivated
                                    Trucks</small></p>
                            {{-- / --}}
                        </div>


                        {{-- For Alert Messages --}}
                        @if (session('msg1'))
                            <div class="alert alert-danger mt-1 mb-1 col-10 mx-auto" role="alert">
                                {{ session('msg1') }}
                            </div>
                        @endif
                        {{-- / --}}
                        {{-- For All trucks Table --}}
                        @can('view-trucks')
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable-basic">
                                    <thead>
                                        <th>No.</th>
                                        <th>Truck Number</th>
                                        {{-- <th>Plate Number</th> --}}
                                        <th>Supervisor</th>
                                        <th>Truck Type</th>
                                        <th>Last Location</th>
                                        <th>Status</th>
                                        <th>Options</th>

                                    </thead>


                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        @endcan
                        {{-- / --}}
                    @endcan
                    {{-- ./ --}}
                </div>
            </div>
            {{-- ./ --}}
        </div>
    </div>



    {{-- start of add Truck Modal --}}


    {{-- ./ --}}

    </div>


    {{-- For Assign single truck Supervisor --}}
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
        <div class="modal-dialog  modal-md modal-dialog-centered " role="document">
            <div class="modal-content">
                {{-- <form id="edit-form" method="POST" action="{{ route('flex.assign-Supervisor') }}"> --}}
                <form id="edit-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="modal-title lead" id="edit-modal-label">Assign Supervisor</h6>
                        <button type="button" class="btn-close  btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="truck_id" id="edit-id">
                        <div class="col-12 mb-1">
                            <label for="">Truck</label>
                            <input type="" disabled class="form-control" name="name" id="edit-plate">

                        </div>
                        <div class="col-12 mb-1">
                            <div class="form-group">
                                <label class="col-form-label col-sm-3">Available Supervisor: </label>
                                <select name="Supervisor_id" class="select2 form-control">
                                    {{-- @forelse($Supervisors as $item)
                                        @php
                                            $assignment = App\Models\SupervisorAssignment::where(
                                                'Supervisor_id',
                                                $item->id,
                                            )->first();
                                        @endphp
                                        @if ($assignment == null)
                                            <option value="{{ $item->id }}">{{ $item->fname }} {{ $item->mname }}
                                                {{ $item->lname }}
                                            </option>
                                        @endif
                                    @empty
                                        <option value=""> There is no Free Supervisor</option>
                                    @endforelse --}}
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-main" data-dismiss="modal">Close</button> --}}
                            <button type="submit" id="assign_Supervisor_btn" class="btn btn-main">Assign
                                Supervisor</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    {{-- / --}}
    {{-- ./ --}}

@endsection
@push('footer-script')
    {{-- For Assign Supervisor --}}
    <script>
        $("#edit-form").submit(function(e) {
            // e.preventDefault();
            $("#assign_Supervisor_btn").html("<i class='ph-spinner spinner me-2'></i> Assigning ...").addClass(
                'disabled');

        });
    </script>

    {{-- For Printing --}}

    <script>
        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            $('#edit-id').val(id);
            $('#edit-plate').val(name);
            $('#edit-description').val(description);
        });

        $(document).ready(function() {
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent()
                });
            })
        });

        function deleteTruck(id) {

            Swal.fire({
                text: 'Are You Sure You Want to Delete This Truck ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url:
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                                );
                            });

                            // alert('Request Cancelled Successifully!! ...');

                            Swal.fire(
                                'Deleted!',
                                'Truck was deleted Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Truck Deletion Failed!! ....',
                                'success'
                            )

                            alert('Truck Deletion Failed!! ...');
                        });
                }
            });


        }

        function deassignSupervisor(id) {

            Swal.fire({
                text: 'Are You Sure You Want to Deassign This Truck?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,Deassign it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url:
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                                );
                            });

                            Swal.fire(
                                'Deassigned!',
                                'Truck was deassigned Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Truck Deassign Failed!! ....',
                                'success'
                            )

                        });
                }
            });


        }
    </script>
    <script>

$('#region').change(function() {
                loadDistrict($('#region').val());
            })

            $('#district').select2();
            $('#district1').select2({
                dropdownParent: $('#create_p')
            });
            $('#region').select2();

            $('#region').on('change', function() {

                loadDistrict($('#region').val());

            });

            function loadDistrict(value) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('district-filters') }}",
                    data: {
                        id: value
                    },
                    success: function(response) {

                        response = JSON.parse(response);
                        var dropdown = $("#district");
                        dropdown.empty();
                            $("#district").prop('required', true);
                            dropdown.append($("<option />").val('').text('Select District'));
                            $.each(response, function(i, item) {
                                 dropdown.append($("<option />").val(item.id).text(item.name));
                            });
                        }
                });

            }
    </script>
@endpush
