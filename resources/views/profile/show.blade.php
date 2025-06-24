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
    <div class="content">
        @php
            $user = Auth::user();
            $today_day = Carbon\Carbon::now();
        @endphp
        <!-- Inner container -->
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card">
                    <div class="sidebar-section-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <div class="table-inbox-image">
                                <div class="bg-warning text-white lh-1 rounded-pill p-1">
                                    <span class="letter-icon fs-sm"></span>
                                </div>
                            </div>
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="#" class="btn btn-outline-white btn-icon rounded-pill">
                                    <i class="ph-pencil"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="letter-icon-title text-body mb-0">
                            {{ Auth::user()->fname . ' ' . Auth::user()->mname . ' ' . Auth::user()->lname }}</h6>
                        <span class="text-muted">{{ Auth::user()->roles->first()->name }}</span>
                    </div>

                    <ul class="nav nav-sidebar">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-user me-2"></i>
                                User Code
                                <span class="fs-sm fw-normal ms-auto">{{ $user->user_code }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#schedule" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-calendar me-2"></i>
                                Created at
                                <span
                                    class="fs-sm fw-normal text-muted ms-auto">{{ $user->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#inbox" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-envelope me-2"></i>
                                Contract Due
                                @php
                                    $date1 = Carbon\Carbon::parse($user->joining_date);
                                    $date2 = Carbon\Carbon::parse($today_day);
                                    $diff = $date1->diffInDays($date2);
                                @endphp
                                @if ($diff < 30)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $diff }} days</span>
                                @elseif ($diff > 30 && $diff <= 60)
                                    <span class="badge bg-pending rounded-pill ms-auto">{{ $diff }} days</span>
                                @elseif ($diff > 60)
                                    <span class="badge bg-success rounded-pill ms-auto">{{ $diff }} days</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item-divider"></li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ph-sign-out me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </form>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="profile">
                        <form id="add_user_form" action="{{ route('profile.update', $user->id) }}"
                            enctype="multipart/form-data" autocomplete="off" method="get" data-parsley-validate>
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Profile information</h5>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name</label>
                                                <input name="fname" type="text" value="{{ $user->fname }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Middle Name</label>
                                                <input name="mname" type="text" value="{{ $user->mname }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input name="lname" type="text" value="{{ $user->lname }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input name="email" type="text" readonly="readonly"
                                                    value="{{ $user->email }}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Phone #</label>
                                                <input name="phone" type="text" value="{{ $user->phone }}"
                                                    class="form-control">
                                                <div class="form-text text-muted">+99-99-9999-9999</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="region">Region</label>
                                                <select name="region" id="region" class="form-control select">
                                                    @foreach ($regions as $region)
                                                        <option value="{{ $region->id }}"
                                                            {{ $region->id == $user->region_id ? 'selected' : '' }}>
                                                            {{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">District</label>
                                                <select name="district" id="district" class="form-control select">
                                                    <option value="{{ $user->districts->id}}" selected>
                                                        {{ $user->districts->name ?? 'Not Selected' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input name="address" type="text" value="{{ $user->address }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Contract Start</label>
                                                <input type="text" value="{{ $user->hire_date }}"
                                                    class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Contract End</label>
                                                <input type="text" value="{{  Carbon\Carbon::parse($user->joining_date)->format('Y-m-d') }}"
                                                    class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
@endsection
