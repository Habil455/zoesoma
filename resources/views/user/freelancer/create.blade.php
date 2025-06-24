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
    <form id="add_user_form" enctype="multipart/form-data" autocomplete="off" method="post" data-parsley-validate>

        <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
            {{-- Personal details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Personal Details</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="fname">First name <span class="text-danger">*<span></label>
                            <input type="text" id="fname" pattern="[a-zA-Z]+" maxlength="15"
                                title="Only enter letters" name="fname" id="name" value="{{ old('fname') }}"
                                class="form-control" placeholder="First Name" required>
                            <span id="fname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="mname">Middle name</label>
                            <input type="text" id="mname" name="mname" value="{{ old('mname') }}"
                                class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters"
                                placeholder="Middle Name">
                            <span id="mname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="lname">Last name <span class="text-danger">*<span> </label>
                            <input type="text" id="lname" name="lname" value="{{ old('lname') }}"
                                class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters"
                                placeholder="Last Name" required>
                            <span id="lname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Gender <span class="text-danger">*<span></label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="gender" value="Male" id="dc_li_c">
                                    <label class="ms-2" for="dc_li_c">Male</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="gender" value="Female" id="dc_li_u">
                                    <label class="ms-2" for="dc_li_u">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*<span></label>
                            <input id="email" type="email" maxlength="50" class="form-control" name="email"
                                value="{{ old('email') }}" id="email" placeholder="example@email.com" required>
                            <span id="email-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    {{-- <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="nationality">Nationality <span
                                    class="text-danger">*<span></label>
                            <select class="form-control select_country select" name="nationality" id="nationality" required>
                                <option selected disabled> Select </option>
                                {{-- @foreach ($countrydrop as $row)
                                <option value="{{ $row->item_code }}">{{ $row->description }}</option>
                            @endforeach -
                            </select>
                            <span id="nationality-error" class="text-danger error-message"></span>
                        </div>
                    </div> --}}

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="status">Marital Status <span
                                    class="text-danger">*<span></label>
                            <select class="form-control" name="status" id="merital_status" required>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                            <span id="status-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    {{-- <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="birthdate">Birthdate <span class="text-danger">*<span></label>
                        <input type="date" placeholder="Date of Birth" class="form-control" name="birthdate"
                            value="{{ old('birthdate') }}" id="birthdate" required>
                        <span id="age" class="text-danger"></span>
                        <span id="birthdate-error" class="text-danger error-message"></span>
                    </div>
                </div> --}}

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="birthdate">Birthdate<span class="text-danger">*<span></label>
                            <input type="date" class="form-control daterange-single" name="birthdate" id="birthdate">
                            <span id="birthdate-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                </div>
            </div>
            {{-- /Personal details section --}}

            <hr>

            {{-- Work Details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Work Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="position-select">Position</label>
                            <input id="position" maxlength="50" class="form-control" name="position" value="{{$position->name}}" readonly>
                        {{-- <span id="email-error" class="text-danger error-message"></span> --}}
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="contract_start">Contract Start <span
                                    class="text-danger">*<span></label>
                            <input type="date" class="form-control daterange-single" name="contract_start"
                                id="contract_start">
                            <span id="contract_start-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="contract_end">Contract End</label>
                            <input type="date" class="form-control daterange-single" name="contract_end"
                                id="contract_end">
                            <span id="contract_end-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="phone-input">Phone Number</label>
                            <input type="tel" class="form-control phone-input" required
                                placeholder="+123 456 789 0123" name="phone" id="phone-input">
                            <small class="form-text text-muted">Format: +[country code] [area code] [local number]</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="region">Region</label>
                            <select name="region" id="region" class="form-control select">
                                <option value="" selected disabled>Select Region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="district">District</label>
                            <select name="district" id="district" class="form-control select">
                                <option value="" selected>Select District</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div class="mb-3">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" placeholder="Enter Address" name="address"
                                id="address">
                            <span class="text-brand-secondary">e.g., Mikocheni, Tanzania</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Add Freelancer</button>
                </div>
            </div>
        </div>

        <script>
            // Add user
            $("#add_user_form").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('freelancer.store') }}", // Add the correct URL here
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response) {
                            $("#add_user_form")[0].reset();
                            $('#tbody').load(document.URL + ' #tbody tr');
                            $("#modal_add_user").modal("hide");
                            new Noty({
                                text: 'User Successfully Inserted.',
                                type: 'success'
                            }).show();
                            // window.location.href = "{{ route('freelancers.index') }}";
                        } else {
                            if (response.status == 400) {
                                let errorsHtml = '<div class="alert alert-danger"><ul>';
                                $.each(response.errors, function(key, value) {
                                    errorsHtml += '<li>' + value + '</li>';
                                });
                                errorsHtml += '</ul></div>';
                                $('#error_message').html(errorsHtml).show();
                            }
                            new Noty({
                                text: 'Not Inserted.',
                                type: 'error'
                            }).show();
                        }
                    }
                });
            });

            document.getElementById('phone-input').addEventListener('input', function(e) {
                let value = e.target.value.replace(/(?!^\+)\D/g, '');
                if (value.length > 1) {
                    value = value.replace(/^(\+\d{1,3})(\d{1,3})?(\d{1,4})?(\d{1,4})?/, function(_, c1, c2, c3, c4) {
                        return [c1, c2, c3, c4].filter(Boolean).join(' ');
                    });
                }
                e.target.value = value;
            });
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
    @endsection
