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
    {{-- <div class="card border-0  border-top  border-top-width-3 border-top-main  rounded-0 d-md-block d-none">
        <div class="card-body pb-0">
        </div>
    </div> --}}

    {{-- Start of Project Requests --}}
    <div class="card  border-top  border-top-width-3 border-top-main  rounded-0 ">
        <div class="card-head p-2">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-activity text-brand-secondary "></i>Insurance Application</h4>
            </div>

            {{-- <div class="btns">
                <a href="" class="btn btn-secondary btn-sm float-end m-1" title="Print Users">
                    <i class="ph-printer me-2"></i> Print
                </a>
            </div> --}}
        </div>

        <div class="card-body ">
            <ul class="nav nav-tabs mb-3 px-2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#requests" class="nav-link active " data-bs-toggle="tab" aria-selected="true" role="tab"
                        tabindex="-1">
                        Waiting Approval
                        <span class="badge bg-dark text-white rounded-pill ms-2">{{ $total_pending_requests }}</span>
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#completed" class="nav-link " data-bs-toggle="tab" aria-selected="false" role="tab">
                        Active
                        <span class="badge bg-dark text-white rounded-pill ms-2">{{ $total_active_applications }}</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- For Goingload Requests --}}

                {{-- For Going Users --}}
                <div class="tab-pane fade active show" id="requests" role="tabpanel">
                    <table class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th style="width: 10%;">Date</th>
                                <th>Customer Name</th>
                                <th>Beneficiaries</th>
                                <th>Monthly Payment</th>
                                <th>Status</th>
                                <th style="width: 10%;" hidden></th>
                                <th style="width: 5%;">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($application_requests as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $application->customer->first_name }} {{ $application->customer->last_name }}
                                    </td>
                                    <td>{{ $application->total_beneficiaries ?? 'Not Available' }}</td>
                                    <td>{{ $application->monthly_payment }}</td>
                                    <td hidden></td>
                                    <td>
                                        @if ($application->status == 1)
                                            <span class="badge bg-danger">Inactive</span>
                                        @elseif ($application->status == 2)
                                            <span class="badge bg-pending">Waiting Approval</span>
                                        @elseif ($application->status == 3)
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($application->status == 2)
                                            <a href="" class="btn btn-sm btn-success edit-button"
                                                title="Approve Trip " data-bs-toggle="modal" data-bs-target="#approval"
                                                data-id="{{ $application->id }}"
                                                {{-- data-name="{{ $item->name }}"
                                                data-description="{{ $item->amount }}" --}}
                                                >

                                                <i class="ph-check-circle"></i>
                                                Approve
                                            </a>
                                        @endif
                                        {{-- 1-inactive, 2 waiting approval, 3-active --}}

                                        {{-- @if ($application->status == 2)
                                            <a href="{{ route('approve.application', $application->id) }}"
                                                class="btn btn-sm btn-success edit-button">
                                                <i class="ph-plus me-2"></i>Approve
                                            </a>
                                        @endif --}}
                                        @can('delete-application')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="deleteRequest({{ $application->id }})">
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


                {{-- For Completed Requests --}}


                <div class="tab-pane fade show" id="completed" role="tabpanel">
                    <table class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th style="width: 10%;">Date</th>
                                <th>Customer Name</th>
                                <th>Beneficiaries</th>
                                <th>Monthly Payment</th>
                                <th>Status</th>
                                <th style="width: 10%;" hidden></th>
                                <th style="width: 5%;">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($active_applications as $application)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                <td>{{ $application->customer->first_name }} {{ $application->customer->last_name }}
                                </td>
                                <td>{{ $application->total_beneficiaries ?? 'Not Available' }}</td>
                                <td>{{ $application->monthly_payment }}</td>
                                <td hidden></td>
                                <td>
                                    @if ($application->status == 1)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif ($application->status == 2)
                                        <span class="badge bg-pending">Waiting Approval</span>
                                    @elseif ($application->status == 3)
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($application->status == 2)
                                        <a href="" class="btn btn-sm btn-success edit-button"
                                            title="Approve Trip " data-bs-toggle="modal" data-bs-target="#approval"
                                            data-id="{{ $application->id }}"
                                            {{-- data-name="{{ $item->name }}"
                                            data-description="{{ $item->amount }}" --}}
                                            >

                                            <i class="ph-check-circle"></i>
                                            Approve
                                        </a>
                                        @elseif ($application->status == 3)
                                        <a href="{{ route('insurance_info.view', $application->id) }}"
                                            class="btn btn-sm btn-secondary edit-button {{ $application->status == '3' ? '' : 'disabled' }}">
                                            <i class="ph ph-info"></i>
                                        </a>
                                    @endif
                                    {{-- 1-inactive, 2 waiting approval, 3-active --}}

                                    {{-- @if ($application->status == 2)
                                        <a href="{{ route('approve.application', $application->id) }}"
                                            class="btn btn-sm btn-success edit-button">
                                            <i class="ph-plus me-2"></i>Approve
                                        </a>
                                    @endif --}}
                                    @can('delete-application')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteRequest({{ $application->id }})">
                                            Delete
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- / --}}
    </div>
    {{-- ./ --}}

    {{-- start of Project Request approval  modal --}}
    <div id="approval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-danger " data-bs-dismiss="modal"></button>
                </div>

                <modal-body class="p-4">
                    <h6 class="text-center">Are you sure you want to Approve this request?</h6>

                    <form action="{{ route('approve-insurance-requests') }}" id="approve_form" method="post">
                    {{-- <form action="" id="approve_form" method="post"> --}}
                        @csrf
                        <input name="application_id" id="application_id" type="hidden">

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
                        <input name="application_id" id="id" type="hidden">

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
                }
            }).then((result) => {
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
            // $('#project_id').val(id);
            $('#application_id').val(id);
            // $('#edit-name').append(name);
            // $('#edit-description').val(description);
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
    <script>
        $('#activate').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var appId = button.data('application_id');
            // Insert into modal input
            $('#application_id').val(appId);
        });

        function loadAmount(value) {
            $.ajax({
                type: "GET",
                url: "{{ route('payment-type-filters') }}",
                data: {
                    id: value
                },
                success: function(response) {
                    console.log(response);
                    $("#payment_type").val(response.payment_type_id);
                    $("#amount").val('Tsh ' + response.amount).prop('readonly', true);
                }
            });

        }
    </script>
@endsection
