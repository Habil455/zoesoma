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
    <div class="row">

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success bg-opacity-10 border-success d-flex justify-content-between">
                    <span class="fw-semibold">Customer Details</span>
                    {{-- <span class="text-success fw-semibold">Due in 5 days</span> --}}
                </div>

                <ul class="list-group list-group-flush border-top">
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Full name:</span>
                        <div class="fw-semibold ms-auto">{{ $customer_details->first_name }} {{ $customer_details->middle_name }}
                            {{ $customer_details->last_name }}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Phone number:</span>
                        <div class="ms-auto">{{ $customer_details->phone_number }}</div>
                    </li>

                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Location:</span>
                        <div class="ms-auto">{{ $customer_details->region->name ?? 'Not Available' }},
                            {{ $customer_details->district->name ?? 'Not Available' }}</div>
                    </li>

                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Personal email:</span>
                        <div class="ms-auto"><a href="#">{{ $customer_details->email ?? 'Not Available' }}</a></div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Occupation:</span>
                        <div class="ms-auto">{{ $customer_details->occupation ?? 'Not Available' }}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">ID Type:</span>
                        <div class="ms-auto">{{ $customer_details->identificationType->name ?? 'Not Available' }}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">ID Number:</span>
                        <div class="badge bg-indigo ms-auto">{{ $customer_details->id_number ?? 'Not Available' }}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Age:</span>
                        <div class="badge bg-pink rounded-pill ms-auto">
                            {{ \Carbon\Carbon::parse($customer_details->date_of_birth)->age }}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Registered By:</span>
                        <div class="fs-base text-uppercase text-muted ms-auto"><samp>{{ $customer_details->users->fname }}
                            {{ $customer_details->users->lname }}<samp></div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Created:</span>
                        <div class="ms-auto">{{ $customer_details->created_at->diffForHumans() }}</div>
                    </li>
                </ul>

                <div class="card-footer d-flex justify-content-between border-top">
                    <span class="text-muted">Updated {{ $customer_details->updated_at->diffForHumans() }}</span>
                    <span class="hstack gap-1">
                        <button href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal_add_supplier"> Edit
                    </button>
                    </span>
                </div>
            </div>
            <!-- /multi column -->
        </div>

        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-indigo bg-opacity-10 border-success d-flex justify-content-between">
                    <span class="fw-semibold">Overseer Details</span>
                    {{-- <span class="text-success fw-semibold">Due in 5 days</span> --}}
                </div>
                <ul class="list-group list-group-flush border-top">
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Overseer Name:</span>
                        <div class="ms-auto">{{ $customer_details->overseers->first_name ?? 'Not Available'}} {{ $customer_details->overseers->last_name ?? 'Not Available'}}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Phone Number:</span>
                        <div class="ms-auto">{{ $customer_details->overseers->phone_number ?? 'Not Available'}}</div>
                    </li>

                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Relationship:</span>
                        <div class="ms-auto">{{ $customer_details->overseers->relationship ?? 'Not Available'}}</div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">ID Details:</span>
                        <div class="ms-auto">{{ $customer_details->overseers->id_types->name ?? 'Not Available'}}:{{ $customer_details->overseers->id_number ?? 'Not Available' }} </div>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="fw-semibold">Created:</span>
                        <div class="ms-auto">{{ $customer_details->overseers->created_at->diffForHumans() }}</div>
                    </li>
                </ul>

                <div class="card-footer d-flex justify-content-between border-top">
                    <span class="text-muted">Updated {{ $customer_details->overseers->updated_at->diffForHumans() }}</span>
                    <span class="hstack gap-1">
                        <button href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modal_edit_overseer"> Edit
                    </button>
                    </span>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-indigo bg-opacity-10 border-success d-flex justify-content-between">
                    <span class="fw-semibold">Beneficiaries Details</span>
                    <button class="btn btn-secondary fw-semibold btn-sm"
                    {{-- data-bs-toggle="modal" --}}
                        {{-- data-bs-target="#modal_add_supplier" --}}
                        >
                        <i class="ph-plus me-2"></i> Beneficiary
                    </button>
                    {{-- <a href="#"><span class="text-success fw-semibold">Add</span></a> --}}
                </div>
                <table class="table datatable-pagination">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Relationship</th>
                            <th>ID Type</th>
                            <th>ID Number</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $customer_beneficiaries = App\Models\CustomerBeneficiary::where('customer_id', $customer_details->id)->get();
                        @endphp
                        @foreach ($customer_beneficiaries as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->first_name}}</td>
                            <td>{{$data->last_name}}</td>
                            <td>{{$data->phone_number ?? 'Not Available'}}</td>
                            <td >{{$data->relationship}}</td>
                            <td >{{$data->identificationType->name ?? 'Not Available'}}</td>
                            <td >{{$data->id_number ?? 'Not Available'}}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph ph-trash me-2"></i>
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('customers.edit')
@endsection
