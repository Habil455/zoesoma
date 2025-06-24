@extends('layouts.vertical', ['title' => 'Dashboard'])
@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
        <h5 class="py-sm-2 my-sm-1">Dashboard</h5>
    </div>
    <div class="alert alert-success alert-dismissible d-flex justify-content-center">
        {{-- <a href="#">
            <img src="../../../assets/images/demo/users/face11.jpg" width="40" height="40" class="rounded-pill" alt="">
        </a> --}}
        <div class="flex-fill ms-3 d-flex align-items-center">
            <span class="me-1">Welcome</span>
            <div class="fw-semibold">{{ Auth::user()->fname }} {{ Auth::user()->lname . ' ' }} <span> </span></div>&nbsp;to ZoeSoma
        </div>
        <div class="fs-sm fw-semibold lh-1 opacity-50 mt-1">
            {{ Auth::user()->positions->name }}
        </div>
    </div>

    @can('view-management-dashboard')
        <div class="card p-2 text-center bordered-0 rounded-0 border-top border-top-width-3 border-top-black">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="bg-success bg-opacity-10 text-dark lh-1 rounded-pill p-2 me-3">
                                <i class="ph-check-circle"></i>
                            </a>
                            <div class="text-center">
                                <div class="fw-semibold">Total Users</div>
                                <span class="text-muted">{{ $total_users }}</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="bg-success bg-opacity-10 text-dark lh-1 rounded-pill p-2 me-3">
                                <i class="ph-users-four"></i>
                            </a>
                            <div class="text-center">
                                <div class="fw-semibold">Total Supervisor</div>
                                <span class="text-muted">{{ $total_supervisors }}</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="bg-success bg-opacity-10 text-dark lh-1 rounded-pill p-2 me-3">
                                <i class="ph-clock"></i>
                            </a>
                            <div class="text-center">
                                <div class="fw-semibold">Total Freelancers</div>
                                <span class="text-muted">{{ $total_freelancers }}</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <a href="#" class="bg-success bg-opacity-10 text-dark lh-1 rounded-pill p-2 me-3">
                                <i class="ph-clock"></i>
                            </a>
                            <div class="text-center">
                                <div class="fw-semibold">Total Customers</div>
                                <span class="text-muted">{{ $total_customers }}</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                    </div>
                    {{-- <div class="col-sm-3">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <a href="#" class="bg-success bg-opacity-10 text-dark lh-1 rounded-pill p-2 me-3">
                        <i class="ph-credit-card"></i>
                    </a>
                    <div class="text-center">
                        <div class="fw-semibold">Total BreakDown</div>
                        <span class="text-muted">342</span>
                    </div>
                </div>
                <div class="w-75 mx-auto mb-3" id="total-online"></div>
            </div> --}}
                </div>
            </div>
            <div class="chart position-relative" id="traffic-sources"></div>
        </div>
        <div class="card border-top border-top-width-3 border-top-main rounded-0">
            <div class="row">
                <div class="col-12 text-center">
                    <strong><br>Monthly Metrics</br></strong>
                </div>
            </div>
            <hr>
            <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
                <div class="d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap w-100">
                    <div class="d-flex align-items-center mb-3 mb-sm-0">
                        <div id="total-users" class="me-3">
                            <div class="fw-semibold">TOTAL USERS</div>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">38,289</h5>
                                <span class="text-success ms-2">
                                    <i class="ph-arrow-up fs-base lh-base align-top"></i>
                                    (+16.2%)
                                </span>
                            </div>
                            <span class="text-muted">May 12, 12:30 am</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mb-sm-0">
                        <div id="total-freelancers" class="me-3">
                            <div class="fw-semibold">TOTAL FREELANCERS</div>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">38,289</h5>
                                <span class="text-success ms-2">
                                    <i class="ph-arrow-up fs-base lh-base align-top"></i>
                                    (+16.2%)
                                </span>
                            </div>
                            <span class="text-muted">May 12, 12:30 am</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mb-sm-0">
                        <div id="total-clients" class="me-3">
                            <div class="fw-semibold">TOTAL CLIENTS</div>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0">2,458</h5>
                                <span class="text-danger ms-2">
                                    <i class="ph-arrow-down fs-base lh-base align-top"></i>
                                    (-4.9%)
                                </span>
                            </div>
                            <span class="text-muted">Jun 4, 4:00 am</span>
                        </div>
                    </div>
                    <div>
                        <a href="#" class="btn btn-indigo">
                            <i class="ph-file-pdf me-2"></i>
                            View report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Freelancer Registration Trend</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="sampleChart1"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="sampleChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endcan
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
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September', 'October', 'November', 'December'],
                    datasets: [{
                        label: 'Insured Clients',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: [28, 48, 40, 19, 86, 27, 90, 45,67,12,65,78]
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
