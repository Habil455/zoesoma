{{-- This is Trip request Page --}}
@extends('layouts.vertical', ['title' => 'All Commission Payments'])
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
                            <div class="fw-semibold">Total Commissions</div>
                            <span class="text-muted text-bold">{{ $total_commission }}</span>
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
                            <div class="fw-semibold">Pending Commissions</div>
                            <span class="text-muted">{{$total_pending_commission}}</span>
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
                            <div class="fw-semibold">Confirmed Commissions</div>
                            <span class="text-muted">{{$confirmed_commissions}}</span>
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
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">

        <div class="card-body ">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-receipt text-brand-secondary "></i> Commission Payments</h4>
            </div>
        </div>
        <ul class="nav nav-tabs mb-3 px-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#pending" class="nav-link active " data-bs-toggle="tab" aria-selected="true" role="tab"
                    tabindex="-1">
                    Waiting Confirmation
                    <span class="badge bg-dark text-brand-secondary rounded-pill ms-2"></span>
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a href="#completed" class="nav-link " data-bs-toggle="tab" aria-selected="false" role="tab">
                    Confirmed
                    <span class="badge bg-dark text-brand-secondary rounded-pill ms-2"></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active show" id="pending" role="tabpanel">
                <table id="" class="table table-striped table-bordered datatable-basic table-responsive">
                    <thead>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Total Commission</th>
                        <th>User</th>
                        <th>Approved By</th>
                        <th>Status</th>
                        {{-- <th>Charges</th> --}}
                        <th hidden>Status</th>
                        <th hidden>Status</th>
                        <th>Options</th>

                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($unconfirmed_commissions as $item)
                            @if ($item != null)
                                @php
                                    // $total_commission = $commission->sum('amount');
                                    $approver = App\Models\User::where('id', $item->approved_by)->first();
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->payment_date }}</td>
                                    <td><small>Tsh </small>{{ number_format($item->amount, 2) }}</td>
                                    <td>
                                        {{ $item->user->fname . ' ' . $item->user->lname ?? ' Not Available' }}
                                    </td>
                                    <td hidden></td>
                                    <td><small>{{ $approver ? $approver->fname . ' ' . $approver->lname : 'Not Available' }}</small>
                                    </td>
                                    <td width="12%" hidden> <small></small>

                                    </td>
                                    <td>
                                        <span
                                            class="badge  {{ $item->status = 1 ? 'bg-pending text-white ' : 'bg-info text-success' }} bg-opacity-10 ">
                                            Waiting Confirmation
                                            {{-- {{ ($payments+$charges) == 0 ? 'Unpaid' : '' }}
                                {{ $remaining < 1 ? 'Fully Paid' : '' }}
                                {{ ($payments+$charges) > 0 && $remaining >= 1 ? 'Partially Paid' : '' }} --}}

                                        </span>
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('insurance_info.view', $item->id) }}" --}}
                                        <a href="" class="btn btn-sm btn-secondary edit-button">
                                            <i class="ph ph-info"></i>
                                        </a>
                                        @if ($item->status = 1)
                                            <a href="" class="btn btn-sm btn-success edit-button"
                                                title="Confirm Payment " data-bs-toggle="modal" data-bs-target="#approval"
                                                data-id="{{ $item->id }}">
                                                <i class="ph-check-circle"></i>
                                                Confirm
                                            </a>
                                        @endif

                                    </td>

                                </tr>
                            @endif
                        @endforeach

                    </tbody>

                </table>
            </div>

            <div class="tab-pane fade show" id="completed" role="tabpanel">
                <table id="" class="table table-striped table-bordered datatable-basic table-responsive">
                    <thead>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Total Commission</th>
                        <th>User</th>
                        <th>Approved By</th>
                        <th>Status</th>
                        {{-- <th>Charges</th> --}}
                        <th hidden>Status</th>
                        <th hidden>Status</th>
                        <th>Options</th>

                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($completed_commissions as $item)
                            @if ($item != null)
                                @php
                                    // $total_commission = $commission->sum('amount');
                                    $approver = App\Models\User::where('id', $item->approved_by)->first();
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->payment_date }}</td>
                                    <td><small>Tsh </small>{{ number_format($item->amount, 2) }}</td>
                                    <td>
                                        {{ $item->user->fname . ' ' . $item->user->lname ?? ' Not Available' }}
                                    </td>
                                    <td hidden></td>
                                    <td><small>{{ $approver ? $approver->fname . ' ' . $approver->lname : 'Not Available' }}</small>
                                    </td>
                                    <td width="12%" hidden> <small></small>

                                    </td>
                                    <td>
                                        @if ($item->status = 1)
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('insurance_info.view', $item->id) }}" --}}
                                        <a href="" class="btn btn-sm btn-secondary edit-button">
                                            <i class="ph ph-info"></i>
                                        </a>

                                    </td>

                                </tr>
                            @endif
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>

    </div>
    {{-- / --}}
    {{-- @endif      --}}
    {{-- @endcan --}}


    {{-- start of approval  modal --}}
    <div id="approval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-danger " data-bs-dismiss="modal"></button>
                </div>

                <modal-body class="p-4">
                    <h6 class="text-center">Are you sure you want to confirm this payment?</h6>

                    <form action="{{ route('confirm-commission-payment') }}" id="approve_form" method="post">
                        {{-- <form action="" id="approve_form" method="post"> --}}
                        @csrf
                        <input name="item_id" id="application_id" type="hidden">

                        {{-- <div class="row mb-2">
                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="reason" required placeholder="Please Enter Remarks Here" class="form-control" rows="3"></textarea>
                            </div>
                        </div> --}}

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
                    <button type="button" class="btn-close " data-bs-dismiss="modal">

                    </button>
                </div>
                <modal-body class="p-4">
                    <h6 class="text-center">Are you Sure you want to Disapprove this request ?</h6>
                    {{-- <form action="{{ url('trips/disapprove-trip') }}" method="post"> --}}
                    @csrf
                    <input name="allocation_id" id="id" type="hidden">
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="">Remark</label>
                            <textarea name="reason" required placeholder="Please Enter Remarks Here" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-4 mx-auto">
                            <button type="submit" class="btn btn-main btn-sm px-4 ">Yes</button>

                            <button type="button" class="btn btn-danger btn-sm  px-4 text-light"
                                data-bs-dismiss="modal">
                                No
                            </button>
                        </div>

                        </form>


                    </div>
                </modal-body>
                <modal-footer>

                </modal-footer>


            </div>
        </div>
    </div>
    {{-- end of disapproval modal --}}
    <script>
        $(document).on('click', '.edit-button', function() {
            $('#edit-name').empty();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');
            $('#edit-id').val(id);
            $('#id').val(id);
            $('#edit-name').append(name);
            $('#edit-description').val(description);
        });
    </script>

    <script>
        $('#approval').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var appId = button.data('id');
            $('#application_id').val(appId);
            // console.log(appId);
        });
    </script>
@endsection
