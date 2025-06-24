<div id="modal_add_user" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  bg-light border-0">
                <h6 class="modal-title text-dark">Add New Insurance Type</h6>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal"></button>
            </div>
            <form class="form-horizontal" id="add_user_form">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div id="error_message"></div>
                        <div class="row mb-2">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter customer Name"
                                        name="name">
                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Durations (In Years)</label>
                                    <input type="number" class="form-control" placeholder="Enter Number of Years"
                                        name="duration_years">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6 mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" id="amount" oninput="formatCurrency(this)" placeholder="Enter Price"
                                            name="price">
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6 col-lg-6 mb-3">
                                        <label class="form-label">Reports To</label>
                                        {{-- @foreach ($regions as $item)
                                            <option value="{{ $item->reg_code }}">{{ $item->reg_name }}</option>
                                        @endforeach --
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-secondary">Add Insurance</button>
                        </div>
            </form>
        </div>
    </div>
</div>
{{-- end of add customer modal --}}
<script>
    // Add customer
    $("#add_user_form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('insurance_types.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // .status == 200
                // Basic initialization
                if (response) {
                    // console.log(response);
                    $("#add_user_form")[0].reset();
                    $('#tbody').load(document.URL + ' #tbody tr');
                    $("#modal_add_user").modal("hide");
                    new Noty({
                        text: 'Successfully Inserted.',
                        type: 'success'
                    }).show().then(() => {
                        window.location.reload();
                    });
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
    document.getElementById('phone-input').addEventListener('input', function(e) {
        let value = e.target.value;

        // Remove all non-digit characters except the "+"
        value = value.replace(/(?!^\+)\D/g, '');

        // Format the value with spaces for better readability
        if (value.length > 1) {
            value = value.replace(/^(\+\d{1,3})(\d{1,3})?(\d{1,4})?(\d{1,4})?/, function(_, c1, c2, c3, c4) {
                return [c1, c2, c3, c4].filter(Boolean).join(' ');
            });
        }

        e.target.value = value;
    });

    function formatCurrency(input) {
    // Remove all non-digit characters except decimal
    let value = input.value.replace(/[^0-9.]/g, '');

    // Split integer and decimal parts
    let parts = value.split('.');
    let integerPart = parts[0];
    let decimalPart = parts.length > 1 ? '.' + parts[1] : '';

    // Format with commas
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    input.value = integerPart + decimalPart;
}
</script>
