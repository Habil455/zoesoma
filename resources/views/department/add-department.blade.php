{{-- start of add wholesaler modal --}}
<div id="modal_add_department" class="modal fade">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header  bg-light border-0">
                <h6 class="modal-title text-dark">Add New Department</h6>
                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal"></button>
            </div>
            <form class="form-horizontal" id="add_department_form">
                @csrf
                <div class="modal-body">
                    <div class="card-body">
                        <div id="error_message"></div>
                        <div class="row mb-2">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Department Name</label>
                                <input type="text" class="form-control" placeholder="Enter First Name" name="name">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" class="btn btn-secondary">Add Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end of add customer modal --}}
<script>
    $("#add_department_form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('department.store')}}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // .status == 200
                // Basic initialization
                if (response) {
                    // console.log(response);
                    $("#add_department_form")[0].reset();
                    $('#tbody').load(document.URL + ' #tbody tr');
                    $("#modal_add_department").modal("hide");
                    new Noty({
                        text: 'Successfully Inserted.',
                        type: 'success'
                    }).show();
                    window.location.reload();
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
</script>
