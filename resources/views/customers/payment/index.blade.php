@extends('layouts.vertical', ['title' => 'Dashboard'])
@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">My Payments</h5>
        </div>
        <div class="col-12">
            <table class="table table-striped table-boadered datatable-basic">
                <thead>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Payment Type</th>
                    <th hidden>Description</th>
                    <th>Amount</th>
                    <th style="min-width: 250px; max-width: 280px;">Received By</th>
                    <th style="width: 11%;">Options</th>
                </thead>
                <tbody>
                    @forelse($insurance_payment as $item)
                        @php

                            $end_date = \Carbon\Carbon::parse($item->end_date);
                            $start_date = \Carbon\Carbon::parse($item->from_date);
                            $duration = $end_date->diffInDays($start_date);
                            // $trailers = App\Models\TrailerAssignment::where(
                            //     'truck_id',
                            //     $item->truck_id,
                            // )->first();
                            // $drivers = App\Models\User::where('position', '9')->get();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>{{ $item->paymentType->name }}</td>
                            <td>
                                <small>Tsh</small> {{ $item->payment_amount }}
                                {{-- <br>
                                                <small> {{ $item->truck->type->name }}</small> --}}
                            </td>
                            <td hidden></td>
                            <td>{{ $item->user->fname }} {{ $item->user->lname }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary view-payment" class="btn btn-primary"
                                    data-bs-popup="tooltip" title="View Payment " data-bs-placement="auto"
                                    data-bs-toggle="modal" data-bs-target="#offload-modal" data-id="{{ $item->id }}"
                                    data-received_by ="{{ $item->user->fname }} {{ $item->user->lname }}"
                                    data-payment_type="{{ $item->paymentType->name }}"
                                    data-attachment={{ $item->attachment }} data-created_at="{{ $item->created_at }}"
                                    data-amount="{{ $item->payment_amount }}">
                                    <i class="ph-info"></i>

                                </button>
                            </td>
                        @empty
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="modal fade" id="offload-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    {{-- {{ route('flex.offload-truck-allocation') }} --}}

                    <ul class="list-group list-group-flush border-top">

                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Date:</span>
                            <div class="ms-auto" id="received-date"></div>
                        </li>

                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Payment Type:</span>
                            <div class="ms-auto" id="payment_type"></div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Amount:</span>
                            <div class="ms-auto" id="paid_amount"><a href="#"></a></div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Received By:</span>
                            <div class="ms-auto" id="receiver"></div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Attachment:</span>
                            <a class="ms-auto" data-bs-popup="tooltip"
                                title="download" data-attachment="{{ $item->attachment }}" id="attachment" target="_blank"></a>
                            {{-- <a id="attachment"></div> --}}
                        </li>

                        {{-- <li class="list-group-item d-flex">
                            <span class="fw-semibold">Registered By:</span>
                            <div class="fs-base text-uppercase text-muted ms-auto"><samp><samp></div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Created:</span>
                            <div class="ms-auto"></div>
                        </li> --}}
                    </ul>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                    {{-- <form method="POST" id="offloading_form" action=""
                            onsubmit="return validateForm()" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h6 class="modal-title lead" id="edit-modal-label">Offload Truck : <input type="text"
                                        id="edit-name1" disabled></h6>
                                <button type="button" class="btn-close btn-danger text-light" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    {{-- <span aria-hidden="true">&times;</span> -
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit-id1">

                                <div class="form-group">
                                    <div class="col-12 mb-1">
                                        <label for="">Loaded: <input type="text" id="edit-loaded" disabled></label>
                                        <hr>
                                    </div>
                                    <div class="col-12 mb-2">

                                        <label for="">Offloading Date</label>
                                        <input type="date" required name="offloading_date" id="edit-odate"
                                            placeholder="Enter Quantity" class="form-control">

                                        <label for="">Quantity</label>
                                        <input type="number" min="0" step="any" required name="quantity"
                                            id="edit-quantity1" placeholder="Enter Quantity" class="form-control">

                                        <input type="hidden" required name="truck_id" id="edit-truck1" class="form-control">

                                        <input type="hidden" required name="allocation_id" id="edit-description1"
                                            class="form-control">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label for="">POD</label>
                                        <input type="file" name="pod" class="form-control" id="pod">
                                        <p id="fileError" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="submit" id="offloading_btn" class="btn btn-main">Offload Truck</button>
                                </div>
                        </form> --}}
                </div>
            </div>
        </div>

    </div>
    <style>
        /* Ensure the charts adjust properly */
        canvas {
            width: 100% !important;
            height: 300px !important;
            /* Adjust height as needed */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx1 = document.getElementById('sampleChart1').getContext('2d');
            var sampleChart1 = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'Client Registration',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: [65, 59, 80, 81, 56, 55, 40]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('sampleChart2').getContext('2d');
            var sampleChart2 = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'Insured Clients',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: [28, 48, 40, 19, 86, 27, 90, 45, 67, 12, 65, 78]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });



        $(document).on('click', '.view-payment', function() {
            var date = $(this).data('created_at');
            console.log(date);

            var received_by = $(this).data('received_by');
            var payment_type = $(this).data('payment_type');
            var attachment = $(this).data('attachment');
            var amount = $(this).data('amount');


            $('#received-date').html(date);
            $('#receiver').html(received_by);
            $('#payment_type').html(payment_type);
            $('#attachment').html(attachment);
            $('#paid_amount').html(amount);
        });

        var file = $(this).data('attachment');
        var url = '/storage/attachments/' + file;

       $('#attachment').text(file)        // show the filename inside the <a>
                        .attr('href', url) // make it clickable
                        .attr('download', file);
    </script>
@endsection
