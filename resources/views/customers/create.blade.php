@extends('layouts.vertical', ['title' => 'Customer Registration'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <form id="add_user_form" action={{ route('customer.store') }} enctype="multipart/form-data" autocomplete="off"
        method="post">
        @csrf
        <div class="card border-top border-top-width-3 border-top-main rounded-0">
            {{-- Personal details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Taarifa za Mwanachama</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg -4">
                        <div class="mb-3">
                            <label class="form-label" for="fname">Jina la Kwanza <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="fname" pattern="[a-zA-Z]+" maxlength="15"
                                title="Only enter letters" name="fname" value="{{ old('fname') }}" class="form-control"
                                placeholder="First Name" required>
                            <span id="fname-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="mname">Jina la Kati</label>
                            <input type="text" id="mname" name="mname" value="{{ old('mname') }}"
                                class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters"
                                placeholder="Middle Name">
                            <span id="mname-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="lname">Jina la Mwisho <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="lname" name="lname" value="{{ old('lname') }}"
                                class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters"
                                placeholder="Last Name" required>
                            <span id="lname-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Jinsia <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input type="radio" name="gender" value="Male" id="gender_male"
                                        class="form-check-input">
                                    <label class="form-check-label" for="gender_male">Ya Kiume</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="gender" value="Female" id="gender_female"
                                        class="form-check-input">
                                    <label class="form-check-label" for="gender_female">Ya Kike</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Barua Pepe <span class="text-danger"></span></label>
                            <input id="email" type="email" maxlength="50" class="form-control" name="email"
                                value="{{ old('email') }}" placeholder="example@email.com">
                            <span id="email-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="birthdate">Tarehe ya kuzaliwa <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="birthdate" id="birthdate" required>
                            <span id="birthdate-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Namba ya Simu<span
                                    class="text-danger">*</span></label>
                            <input id="phone-input" type="text" maxlength="50" class="form-control" name="phone"
                                value="{{ old('phone') }}" placeholder="+255 654 8892 55" required>
                            <span id="phone-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="occupation" class="form-label">Kazi <span class="text-danger">*</span></label>
                            <input id="occupation" type="text" maxlength="50" class="form-control" name="occupation"
                                value="{{ old('occupation') }}" placeholder="Occupation" required>
                            <span id="occupation-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="region">Mkoa</label>
                            <select name="region" id="region" class="form-control select" required>
                                <option value="" selected disabled>Chagua Mkoa</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="district">Wilaya</label>
                            <select name="district" id="district" class="form-control select" required>
                                <option value="" selected>Chagua Wilaya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="idtype">Aina ya Kitambulisho <span
                                    class="text-danger">*</span></label>
                            <select name="idtype" id="idtype" class="form-control select" required>
                                <option value="" selected disabled>Chagua aina</option>
                                @foreach ($identification_types as $id)
                                    <option value="{{ $id->id }}">{{ $id->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="cust_id_no">Namba ya Kitambulisho <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="cust_id_no" name="cust_id_no"
                                value="{{ old('cust_id_no') }}" class="form-control" maxlength="150" required>
                            <span id="cust_id_no-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- /Personal details section --}}
            <hr>
            {{-- Insurance Details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Taarifa za Bima</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="insurance_purpose" class="form-label">Lengo la Bima<span
                                    class="text-danger">*</span></label>
                            <select name="insurance_purpose" id="insurance_types" class="form-control select" required>
                                <option value="" selected disabled>Chagua aina</option>
                                @foreach ($Insurance_types as $id)
                                    <option value="{{ $id->id }}">{{ $id->name }}</option>
                                @endforeach
                            </select>
                            <span id="insurance_purpose-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="monthly_fee" class="form-label">Kiasi cha ada kwa Mwezi <span
                                    class="text-danger">*</span></label>
                            <input id="monthly_fee" type="text" maxlength="50" class="form-control"
                                name="monthly_fee" value="{{ old('monthly_fee') }}" placeholder="Monthly Fee">
                            <span id="monthly_fee-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="insurance_term" class="form-label">Muda wa Bima<span
                                    class="text-danger">*</span></label>
                            <input id="insurance_term" type="text" maxlength="50" class="form-control"
                                name="insurance_term" value="{{ old('insurance_term') }}" placeholder="Insurance Term"
                                required>
                            <span id="insurance_term-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- /Insurance Details section --}}
            <hr>
            {{-- Beneficiaries Details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Taarifa za Mnufaishwa</h5>
            </div>
            <div class="card-body">
                <div id="dynamicAddRemove">
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="benef_fname" class="form-label">Jina la Kwanza <span
                                        class="text-danger">*</span></label>
                                <input id="benef_fname" type="text" maxlength="50" class="form-control"
                                    name="moreBeneficiaries[0][benef_fname]" value="{{ old('benef_fname') }}"
                                    placeholder="Name" required>
                                <span id="benef_fname-error" class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="benef_lname" class="form-label">Jina la Mwisho <span
                                        class="text-danger">*</span></label>
                                <input id="benef_lname" type="text" maxlength="50" class="form-control"
                                    name="moreBeneficiaries[0][benef_lname]" value="{{ old('benef_lname') }}"
                                    placeholder="Name" required>
                                <span id="benef_lname-error" class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="benef_relation" class="form-label">Uhusiano <span
                                        class="text-danger">*</span></label>
                                <input id="benef_relation" type="text" maxlength="50" class="form-control"
                                    name="moreBeneficiaries[0][benef_relation]" value="{{ old('benef_relation') }}"
                                    placeholder="benef_relation" required>
                                <span id="benef_relation-error" class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label for="benef_phone" class="form-label">Namba ya Simu <span
                                        class="text-danger"></span></label>
                                <input id="benef_phone" type="text" maxlength="50" class="form-control"
                                    name="moreBeneficiaries[0][benef_phone]" value="{{ old('benef_phone') }}"
                                    placeholder="Phone Number">
                                <span id="benef_phone-error" class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label" for="idtype">Aina ya Kitambulisho <span
                                        class="text-danger"></span></label>

                                <select name="moreBeneficiaries[0][benef_idtype]" id="identification_types"
                                    class="form-control select" >
                                    <option value="null" selected disabled>Chagua aina</option>
                                    @foreach ($identification_types as $id)
                                        <option value="{{ $id->id }}">{{ $id->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label" for="benef_id_no">Namba ya Kitambulisho <span
                                        class="text-danger">*</span></label>
                                <input type="text" min="0" id="benef_id_no"
                                    name="moreBeneficiaries[0][benef_id_no]" value="{{ old('benef_id_no') }}"
                                    class="form-control" maxlength="150" >
                                <span id="benef_id_no-error" class="text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col-md-1 col-lg-1">
                            <br>
                            <input type="button" name="add" id="add-btn" class="btn btn-sm btn-success"
                                value="+" style="margin-top: 8px">
                        </div>
                    </div>
                </div>
            </div>
            {{-- /Beneficiaries Details section --}}
            <hr>
            {{-- Overseer Details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Taarifa za Msimamizi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="overseer_fname" class="form-label">Jina la Kwanza <span
                                    class="text-danger">*</span></label>
                            <input id="overseer_fname" type="text" maxlength="50" class="form-control"
                                name="overseer_fname" value="{{ old('overseer_fname') }}" placeholder="Name" required>
                            <span id="overseer_fname-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="overseer_lname" class="form-label">Jina la Mwisho <span
                                    class="text-danger">*</span></label>
                            <input id="overseer_lname" type="text" maxlength="50" class="form-control"
                                name="overseer_lname" value="{{ old('overseer_lname') }}" placeholder="Name" required>
                            <span id="overseer_lname-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="overseer_relation" class="form-label">Uhusiano <span
                                    class="text-danger">*</span></label>
                            <input id="overseer_relation" type="text" maxlength="50" class="form-control"
                                name="overseer_relation" value="{{ old('overseer_relation') }}"
                                placeholder="Relationship" required>
                            <span id="overseer_relation-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label for="overseer_phone" class="form-label">Namba ya Simu <span
                                    class="text-danger">*</span></label>
                            <input id="overseer_phone" type="text" maxlength="50" class="form-control"
                                name="overseer_phone" value="{{ old('overseer_phone') }}" placeholder="Phone Number"
                                required>
                            <span id="overseer_phone-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="overseer_idtype">Aina ya Kitambulisho<span
                                    class="text-danger">*</span></label>

                            <select name="overseer_idtype" id="overseer_idtype" class="form-control select">
                                <option value="" selected disabled>Chagua aina</option>
                                @foreach ($identification_types as $id)
                                    <option value="{{ $id->id }}">{{ $id->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="overseer_id_no">Namba ya Kitambulisho<span
                                    class="text-danger">*</span></label>
                            <input type="text" min="0" id="overseer_id_no" name="overseer_id_no"
                                value="{{ old('overseer_id_no') }}" class="form-control" maxlength="150">
                            <span id="overseer_id_no-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>
                <p class="bold-text text-danger">Mimi <span class="bold" id="name_attestation"></span> Ninathibitisha
                    kwamba Taarifa nilizotoa hapo juu ni kweli na sahihi kwa uelewa wangu wote.</p>
                {{-- /Overseer Details section --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Add Customer</button>
                </div>
            </div>
        </div>
    </form>

    <script>
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
                    dropdown.append($("<option />").val('').text('Chagua Wilaya'));
                    $.each(response, function(i, item) {
                        dropdown.append($("<option />").val(item.id).text(item.name));
                    });
                }
            });

        }
    </script>



    <script>
        let maxEntries = Infinity;
        let currentEntries = 1;
        let counter = 1;


        $(document).ready(function() {
            var i = 0;


            // Listen to insurance type change
            $('#insurance_types').on('change', function() {
                const selectedText = $(this).find('option:selected').text().trim();

                // If it's "Bima ya Bodaboda", set max to 7, else Infinity
                if (selectedText === 'Bima ya Bodaboda') {
                    maxEntries = 7;
                }


                if (selectedText === 'Bima ya Elimu') {
                    maxEntries = Infinity;
                }

                // Reset current entries (optionally, you can count existing dynamically)
                currentEntries = $('.remove-row').length + 1;
            });

            $("#add-btn").click(function() {
                if (currentEntries >= maxEntries) {
                    alert("Umefikia kikomo cha kuingiza wanufaika (" + maxEntries + ")");
                    return;
                }


                ++i;
                ++currentEntries;
                const selectedText = $('#insurance_types option:selected').text().trim();
                if (selectedText === 'Bima ya Elimu' && baseMonthlyFee > 0) {
                    const currentFee = parseInt($("#monthly_fee").val()) || 0;
                    $("#monthly_fee").val(currentFee + baseMonthlyFee);
                }

                $("#dynamicAddRemove").append(`
            <div class="row remove-row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Jina la Kwanza <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control" name="moreBeneficiaries[${i}][benef_fname]" placeholder="Name" required>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Jina la Mwisho <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control" name="moreBeneficiaries[${i}][benef_lname]" placeholder="Name" required>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Uhusiano <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control" name="moreBeneficiaries[${i}][benef_relation]" placeholder="Uhusiano" required>
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Namba ya Simu <span class="text-danger"></span></label>
                        <input type="text" maxlength="50" class="form-control" name="moreBeneficiaries[${i}][benef_phone]" placeholder="Phone Number">
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
               <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Aina ya Kitambulisho <span class="text-danger"></span></label>
                        <select name="moreBeneficiaries[${i}][benef_idtype]" class="form-control select" id="identification_types">
                            <option value="" selected disabled>Chagua aina</option>
                            @foreach ($identification_types as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Namba ya Kitambulisho <span class="text-danger">*</span></label>
                        <input type="text" min="0" name="moreBeneficiaries[${i}][benef_id_no]" class="form-control" maxlength="150" >
                        <span class="text-danger error-message"></span>
                    </div>
                </div>
                <div class="col-md-1 col-lg-1">
                    <br>
                    <input type="button" class="btn btn-sm btn-danger remove-tr" value="x" style="margin-top: 8px">
                </div>
            </div>
        `);
            });

            // Remove row on "x" click
            $(document).on('click', '.remove-tr', function() {
                $(this).closest('.remove-row').remove();
                --currentEntries;

                const selectedText = $('#insurance_types option:selected').text().trim();
                if (selectedText === 'Bima ya Elimu' && baseMonthlyFee > 0) {
                    const currentFee = parseInt($("#monthly_fee").val()) || 0;
                    const newFee = Math.max(currentFee - baseMonthlyFee, baseMonthlyFee);
                    $("#monthly_fee").val(newFee);
                }
            });
            console.log('Total fee:', total_fee);

        });


        $('#insurance_types').select2();

        $('#insurance_types').on('change', function() {

            getInsuranceDetails($('#insurance_types').val());

        });

        function getInsuranceDetails(value) {
            $.ajax({
                type: "GET",
                url: "{{ route('insurance_type-filters') }}",
                data: {
                    id: value
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response) {
                        baseMonthlyFee = parseInt(response.price);
                        $("#monthly_fee").val(response.price).prop('readonly', true);
                        $("#insurance_term").val(response.duration_year + ' year(s)')
                            .prop('readonly', true);

                        currentEntries = $('.remove-row').length + 1;
                    }
                }
            });

        }
    </script>
@endsection
