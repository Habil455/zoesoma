<div id="modal_add_user" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  bg-light border-0">
                <h6 class="modal-title text-dark">Add New Configuration</h6>
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
                                    <label class="form-label">Payment Type</label>
                                    <select name="payment_type" id="payment_type" class="select form-control">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($payment_types as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Payment Amount</label>
                                    <input id="payment_amount" type="number" class="form-control" name="payment_amount"
                                        value="{{ old('payment_amount') }}">
                                </div>
                                <hr>
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role_id" id="role" class="select form-control">
                                        <option value="" selected>Select Role</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="double" class="form-control" placeholder="Enter Amount"
                                        name="commission_amount">
                                </div>


                                {{-- <div class="row"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-secondary">Add configuration</button>
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
            url: "{{ route('save_commission_configuration') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response && response.status !== 400) {
                    $("#add_user_form")[0].reset();
                    $('#tbody').load(location.href + ' #tbody tr');
                    $("#modal_add_wholesaler").modal("hide");

                    new Noty({
                        text: 'Successfully Inserted.',
                        type: 'success',
                        timeout: 1500
                    }).show();

                    // Delay redirect slightly to let the Noty display
                    setTimeout(function() {
                        window.location.href =
                            "{{ route('commission-configuration.index') }}";
                    }, 1600);

                } else {
                    if (response.status === 400) {
                        document.getElementById('error_message').style.display = 'block';
                        let errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each(response.errors, function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul></div>';
                        $('#error_message').html(errorsHtml);
                    }

                    new Noty({
                        text: 'Not Inserted.',
                        type: 'error'
                    }).show();
                }
            },
            error: function(xhr) {
                new Noty({
                    text: 'An unexpected error occurred.',
                    type: 'error'
                }).show();
                console.error(xhr.responseText);
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
</script>
<script>
    $('#payment_type').on('change', function() {

        loadAmount($('#payment_type').val());

    });
    function loadAmount(value) {
        $.ajax({
            type: "GET",
            url: "{{ route('payment-type-filters') }}",
            data: {
                id: value
            },
            success: function(response) {
                $("#payment_amount").val(response.amount).prop('readonly', true);
            }
        });

    }
</script>
