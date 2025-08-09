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
                            <td>{{$item->paymentType->name}}</td>
                            <td>
                                <small>Tsh</small> {{ $item->payment_amount }}
                                {{-- <br>
                                                <small> {{ $item->truck->type->name }}</small> --}}
                            </td>
                            <td hidden></td>
                            <td>{{$item->user->fname}} {{$item->user->lname}}</td>
                            <td>
                                <a href="" title="View Info" class="btn btn-sm btn-primary">
                                    <i class="ph-info"></i>
                                </a>
                            </td>
                        @empty
                    @endforelse
                </tbody>

            </table>
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
    </script>
@endsection
