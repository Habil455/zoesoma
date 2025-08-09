{{-- This is Trip request Page --}}
@extends('layouts.vertical', ['title' => 'My Commissions'])
@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush
@section('content')
    <!-- /traffic sources -->
    {{-- @can('view-progress-trips') --}}
    {{-- @if ($pending->count() > 0) --}}
    {{-- Start of Trip Requests --}}
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">

        <div class="card-body ">
            <div class="d-flex justify-content-between">
                <h4 class="lead "> <i class="ph-receipt text-brand-secondary "></i> Commission Payments</h4>
            </div>
        </div>
        <table id="" class="table table-striped table-bordered datatable-basic table-responsive">
            <thead>
                <th>No.</th>
                <th>Date</th>
                <th>Total Commission</th>
                <th hidden>Customer</th>
                <th>Approved By</th>
                <th hidden>Paid</th>
                {{-- <th>Charges</th> --}}
                <th hidden>Status</th>
                <th>Options</th>

            </thead>

            <tbody>
                <?php $i = 1; ?>
                @foreach ($commissions_payment as $item)

                    @if ($item != null)
                    @php
                        // $total_commission = $commission->sum('amount');
                        $approver = App\Models\User::where('id', $item->approved_by)->first();
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->payment_date }}</td>
                        <td><small>Tsh </small>{{ number_format($item->total_commission, 2) }}</td>
                        {{-- <td>
                            {{ $item->customer->first_name. ' '.$item->customer->last_name ?? ' Not Available' }}
                        </td> --}}
                        <td hidden></td>
                        <td><small>{{ $approver ? ($approver->fname . ' ' . $approver->lname) : 'Not Available' }}</small></td>
                        <td width="12%" hidden> <small></small>

                        </td>
                        <td>
                            {{-- <a href="{{ route('insurance_info.view', $item->id) }}" --}}
                            <a href=""
                                class="btn btn-sm btn-secondary edit-button">
                                <i class="ph ph-info"></i>
                            </a>
                            {{-- <span
                                class="badge  {{ $remaining <1  ? 'bg-success text-success ' : 'bg-info text-warning' }} bg-opacity-10 ">
                                {{ ($payments+$charges) == 0 ? 'Unpaid' : '' }}
                                {{ $remaining < 1 ? 'Fully Paid' : '' }}
                                {{ ($payments+$charges) > 0 && $remaining >= 1 ? 'Partially Paid' : '' }}

                            </span> --}}

                        </td>
                        <td hidden>
                        </td>
                    </tr>
                    @endif
                @endforeach

            </tbody>
        </table>

    </div>
    {{-- / --}}
    {{-- @endif      --}}
    {{-- @endcan --}}


    {{-- start of approval  modal --}}
    <div id="approval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close " data-bs-dismiss="modal">

                    </button>
                </div>
                <modal-body class="p-4">
                    <h6 class="text-center">Are you Sure you want to Confirm this request ?</h6>
                    {{-- <form action="{{ url('trips/approve-trip') }}" method="post"> --}}
                    @csrf
                    <input name="allocation_id" id="edit-id" type="hidden">
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="">Remark</label>
                            <textarea name="reason" required placeholder="Please Enter Remarks Here" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-4 mx-auto">
                            <button type="submit" class="btn btn-main btn-sm px-4 ">Yes</button>

                            <button type="button" class="btn btn-danger btn-sm  px-4 text-light" data-bs-dismiss="modal">
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

                            <button type="button" class="btn btn-danger btn-sm  px-4 text-light" data-bs-dismiss="modal">
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
@endsection
