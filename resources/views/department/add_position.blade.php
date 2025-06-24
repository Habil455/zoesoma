<div id="modal_add_user" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  bg-light border-0">
                <h6 class="modal-title text-dark">Add New Position</h6>
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
                                    <label class="form-label">Position Name</label>
                                    <input type="text" class="form-control" placeholder="Enter customer Name"
                                        name="name">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <select name="department" id="firm-region" class="select form-control">
                                        <option value="" selected>Select Option</option>
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label">Reports To</label>
                                        {{-- @foreach ($regions as $item)
                                            <option value="{{ $item->reg_code }}">{{ $item->reg_name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-secondary">Add Position</button>
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
            url: "{{route('configure_user_position')}}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // .status == 200
                // Basic initialization
                if (response) {
                    // console.log(response);
                    $("#add_wholesaler_form")[0].reset();
                    $('#tbody').load(document.URL + ' #tbody tr');
                    $("#modal_add_wholesaler").modal("hide");
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




{{-- @can('add-position')
<?php if (session('mng_org') || 1) { ?>
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">

    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
      <div class="card-head">
        <h2 class="text-warning"><i class="fa fa-tasks"></i> Add Position</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="card-body">
        <div id="positionAddFeedBack"></div>

        <form id="addPosition12" enctype="multipart/form-data" action="{{ route('flex.addPosition') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
          @csrf
          <!-- START -->
          <div class="row">
            <div class="form-group col-6 mb-3">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Name</label>
              </label>
              <input type="text" required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name">


            </div>
            <div class="form-group col-6 mb-3">
              <label class="control-label col-md-3  col-xs-6">Organization Level</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <select required="" id='org' name="organization_level" class="select_level form-control">

                  <?php foreach ($levels as $row) { ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                </select>
              </div>
            </div>


            <div class="form-group col-6 mb-3">
              <label class="control-label col-md-3  col-xs-6">Department</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <select required="" id='dept' name="department" class="select3_single form-control">
                  <option></option>
                  <?php foreach ($ddrop as $row) { ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-6 mb-3">
              <label class="control-label col-md-3  col-xs-6">Reports To</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-group">
                  <select required="" id="pos" name="parent" class="select1_single form-control" tabindex="-1">
                    <option></option>

                    <?php foreach ($all_position as $row) {
                      // if ($row->name == $parent) continue;
                    ?>
                      <option value="<?php echo $row->position_code . "|" . $row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group col-12 mb-3">
              <label class="control-label" for="last-name">Purpose of This Position</label>
              </label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control col-md-7 col-xs-12" name="purpose" placeholder="Purpose" rows="3"></textarea>
              </div>
            </div> <br>
            <div class="form-group col-8 mb-3">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
              </label>

            </div> <br>
            <!-- END -->
            <div class="form-group col-4">
              <div class="">
                <input type="submit" class="btn btn-main form-control" />
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>


<?php } ?>

@endcan --}}


