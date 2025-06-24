@extends('layouts.vertical', ['title' => 'Positions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <div class="right_col" role="main">

            <div class="clearfix"></div>
            <div class="row">
                <!--Start Tabs Content-->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">


                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <div class="card border-top   rounded-0 ">
                                    <div class="card-head p-2">
                                        <h2 class="text-warning">List of Positions </h2>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <div class="clearfix"></div>

                                        @can('add-position')
                                            <a class="btn btn-secondary btn-sm float-end m-1" title="Add New Position"
                                                data-bs-toggle="modal" data-bs-target="#modal_add_user">
                                                <i class="ph-plus me-2"></i> Add Position
                                            </a>
                                        @endcan
                                    </div>
                                    {{-- href="{{ route('user.create') }}" --}}

                                    <div class="card-body">

                                        <table id="datatable" class="table table-striped table-bordered datatable-basic">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th hidden>Reports To</th>
                                                    <th>Department</th>
                                                    <th>Created By</th>
                                                    <th>Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($position as $row)
                                                    <tr id="record{{ $row->id }}">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td><b>{{ $row->department->name }}</b></td>
                                                        <td>{{$row->user->fname}} {{$row->user->lname}}</td>
                                                        {{-- <td>{{ $row->id == 6 ? 'Top Position' : $row->parent }}</td> --}}
                                                        <td>
                                                            <form
                                                                action="{{ route('delete_position', ['id' => $row->id]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this position?')">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="ph-trash"></i>
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                            <!--END EDIT TAB-->

                        </div>
                    </div>

                </div>
            </div>



        @include('department.add_position')

    </div>
    </div>
@endsection

@push('footer-script')
    <script type="text/javascript">
        $(".select_level").select2({
            placeholder: "Select Organization Level",
            allowClear: true
        });
        $('#addPosition').submit(function(e) {
            e.preventDefault();
            var maxSalary = $('#maxSalary').val();
            var minSalary = $('#minSalary').val();
            if (minSalary > maxSalary) {
                alert("Maximum Salary should be Greater Than Minimum salary");
            } else {
                $.ajax({
                        url: "{{ route('configure_user_position') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "post",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false
                    })
                    .done(function(data) {
                        $('#positionAddFeedBack').fadeOut('fast', function() {
                            $('#positionAddFeedBack').fadeIn('fast').html(data.message);
                        });
                        notify('Position added successfully!', 'top', 'right', 'success');
                        setTimeout(function() { // wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Request Failed!! ...');
                    });
            }
        });
    </script>


    <script>
        function activatePosition(id) {
            if (confirm("Are You Sure You Want To Activate This Department") == true) {
                var id = id;
                $('#hide' + id).show();
                $.ajax({
                    url: "<?php echo url('flex/activatePosition'); ?>/" + id,
                    success: function(data) {
                        // success :function(result){
                        // $('#alert').show();

                        if (data.status == 'OK') {
                            alert("SUCCESS!");
                            $('#domain' + id).hide();
                            $('#feedBackTable2').fadeOut('fast', function() {
                                $('#feedBackTable2').fadeIn('fast').html(data.message);
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if (data.status != 'SUCCESS') {
                            alert("Property Not Activated, Error In Activation");
                        }


                    }

                });
            }
        }
    </script>
@endpush
