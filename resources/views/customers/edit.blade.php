{{-- start of add Supplier modal --}}
<div id="modal_add_supplier" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white border-0">
                <h6 class="modal-title">Customer Details</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form class="form-horizontal" method="POST" id="edit_customer_form" action="{{route('update_customer', $customer_details->id)}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div id="error_message"></div>
                        <div class="row mb-3">
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control"
                                    name="first_name" value="{{ $customer_details->first_name }}">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control"
                                    name="middle_name" value="{{ $customer_details->middle_name }}">
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control"
                                    name="last_name" value="{{ $customer_details->last_name }}">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter Phone Number"
                                    name="phone" value="{{ $customer_details->phone_number }}">
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Enter Email"
                                    name="email" value="{{ $customer_details->email }}">

                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Occupation</label>
                                <input type="text" class="form-control" placeholder="Enter Company"
                                    name="occupation" value="{{ $customer_details->occupation }}">
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="region">Region</label>
                                        <select name="region_id" id="region" class="form-control select">
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}"
                                                    {{ $region->id == $customer_details->region_id ? 'selected' : '' }}>
                                                    {{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">District</label>
                                        <select name="district" id="district" class="form-control select">
                                            <option value="{{ $customer_details->district->id}}" selected>
                                                {{ $customer_details->district->name ?? 'Not Selected' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="birthdate">Date of Birth <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="birthdate" id="birthdate"
                                            value="{{ $customer_details->date_of_birth }}">
                                        <span id="birthdate-error" class="text-danger error-message"></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6 col-lg-6 mb-3">
                                <label class="form-label">ID Type</label>
                                <select name="id_type" id="id_type" class="form-control select">
                                    @foreach ($id_types as $data)
                                        <option value="{{ $data->id }}"
                                            {{ $data->id == $customer_details->id_type ? 'selected' : '' }}>
                                            {{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-lg-6 mb-3">
                                <label class="form-label">ID Number</label>
                                <input type="text" class="form-control" placeholder="Enter Address"
                                    name="id_no" value="{{ $customer_details->id_number }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" id="update_btn" class="btn btn-indigo">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end of add Supplier modal --}}
<script>
    // Add Supplier
    $("#add_supplier_form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // Basic initialization
                if (response.status == 200) {
                    $("#add_supplier_form")[0].reset();
                    $('#tbody').load(document.URL + ' #tbody tr');
                    $("#modal_add_supplier").modal("hide");
                    new Noty({
                        text: 'Successfully Inserted.',
                        type: 'success'
                    }).show();
                } else {
                    if (response.status == 400) {
                        document.getElementById('error_message').style.display = 'block';
                        errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(response.errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul></di>';
                        $('#error_message').html(errorsHtml);
                    }
                    new Noty({
                        text: 'Not Inserted.',
                        type: 'error'
                    }).show();
                }
            }

        });
    });

</script>
<script>
    $("#edit_customer_form").submit(function(e) {
        $("#update_btn").html("<i class='ph-spinner spinner me-2'></i> Updating...")
            .addClass('disabled');
    });

    $('#region').change(function() {
            loadDistrict($('#region').val());

        })

        $('#district').select2();
        $('#district1').select2({
            dropdownParent: $('#create_p')
        });
        $('#region').select2();

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
