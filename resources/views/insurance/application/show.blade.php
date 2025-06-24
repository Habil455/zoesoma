{{-- This is A Register Truck Page --}}
@extends('layouts.vertical', ['title' => 'Insurance Application Details'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
    @include('layouts.shared.page-header')
@endsection

@section('content')
    <div class="card border-top  border-top-width-3 border-top-main  rounded-0">

        <div class="card-body ">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="lead  "> <i class="ph-clipboard text-brand-secondary"></i>

                        <code>
                            @if ($application)
                                @if ($application->insurance_type == 1)
                                    Bima Elimu-{{ $application->id }} : {{ $application->customer->first_name }}  {{-- For Bima ya Elimu--}}
                                    {{ $application->customer->last_name }}
                                @elseif ($application->insurance_type == 2)
                                    Bima Boda - {{ $application->id }}: {{ $application->customer->first_name }}  {{-- For Bima ya Elimu--}}
                                    {{ $application->customer->last_name }}
                                @elseif ($application->insurance_type == 3)
                                    Bima Busi- {{ $application->id }}: {{ $application->customer->first_name }}  {{-- For Bima ya Elimu--}}
                                    {{ $application->customer->last_name }}
                                     {{-- For Bima ya Bodaboda--}}
                                @else
                                    Not Assigned
                                @endif
                            @endif
                        </code>
                    </h4>


                </div>

            </div>
            <hr>
            <div class="col-12 mx-auto">
                {{-- End of Trip Remark --}}

                {{-- Start of Trip Details --}}
                @include('insurance.application.view_application_info')
                {{-- End of Trip Details --}}

                <div class="row">
                    <hr>
                    <div class="col-md-6">
                        <p> <i class="ph ph-wallet text-brand-secondary"></i>
                            {{-- <code>
                                @if ($trip)
                                    {{ $trip->ref_no }}
                                @else
                                    Not Assigned
                                @endif
                            </code> --}}
                            Application Fee
                        </p>

                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-secondary btn-sm float-end add-payment" data-bs-toggle="modal"
                            data-application_id="{{ $application->id }}" onclick="fetchApplication({{ $application->id }})"
                            data-bs-target="#add_payment">
                            <i class="ph-plus me-2"></i> Add Payment
                        </button>

                        <span class="badge bg-success bg-opacity-10 text-success float-end me-2">
                            @if ($application->status == 3)
                                <i class="ph-check-circle me-2"></i> Paid
                            @else
                                <i class="ph-x-circle me-2"></i> Not Approved
                            @endif
                        </span>

                        @php
                            $payments = App\Models\InsurancePayment::where('application_id', $application->id)
                                ->where('payment_type', 1)
                                ->first();
                        @endphp

                        <p class="btn btn-main btn-sm float-end me-2">
                            <i class="text-bold"></i> Tsh {{ $payments->payment_amount }}
                        </p>
                    </div>


                    {{-- <div class="col-12 col-md-12">
                        <hr>
                        <small><b><i class="ph-cash text-brand-secondary"></i> PAYMENTS</b></small>
                        @if (session('error'))
                            <div class="alert alert-danger mt-1 mb-1 col-10 mx-auto" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="col-md-12">
                            <a {{-- href="{{ url('/trips/truck-allocation/' . base64_encode($trip->allocation_id)) }}"  class="btn btn-perfrom btn-sm float-end mx-2">
                                <i class="ph ph-plus me-2"></i> Payment
                            </a>
                        </div>
                    </div> --}}


                    <hr>

                    {{-- For Trip Trucks --}}
                    <div class="col-12">
                        <table class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th hidden>Trailer</th>
                                <th>Duration</th>
                                <th>Options</th>
                            </thead>
                            <tbody>
                                    {{-- @php
                                        $trucks = App\Models\::where('allocation_id', $allocation->id)
                                            ->latest()
                                            ->get();
                                    @endphp --}}
                                    <?php $i = 1; ?>
                                    @forelse($insurance_payment as $item)
                                        @php

                                        $end_date = \Carbon\Carbon::parse($item->end_date);
                                        $start_date = \Carbon\Carbon::parse($item->from_date);
                                        $duration = $end_date->diffInDays($start_date);
                                            // $trailers = App\Models\TrailerAssignment::where(
                                            //     'truck_id',
                                            //     $item->truck_id,
                                            // )->first();
                                            // $drivers = App\Models\User::where('position', '9')->get();
                                        @endphp
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>
                                               <small>Tsh</small> {{ $item->payment_amount }}
                                                {{-- <br>
                                                <small> {{ $item->truck->type->name }}</small> --}}
                                            </td>
                                            <td hidden></td>
                                            <td>{{ $duration ?? 'N/A' }}</td>
                                            <td>
                                                {{-- <a href="{{ url('' . base64_encode($item->id)) }}" --}}
                                                <a href=""
                                                    title="View Info" class="btn btn-sm btn-primary">
                                                    <i class="ph-info"></i>
                                                </a>
                                            </td>
                                        @empty
                                    @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>





            </div>
            {{-- <hr> --}}
            <div class="modal-footer mt-2">

            </div>
            {{-- </form> --}}
        </div>
    </div>


    </div>
    </div>

    <div class="">
        {{-- For Assign single truck Trailer --}}
        <div class="modal fade" id="edit-trailer" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
            <div class="modal-dialog  modal-md modal-dialog-centered " role="document">
                <div class="modal-content">
                    <form id="trailer-form" method="POST" action="">
                        {{-- <form id="trailer-form" method="POST" action="{{ route('flex.change_trailer') }}"> --}}
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h6 class="modal-title lead" id="edit-modal-label">Change Trailer</h6>
                            <button type="button" class="btn-close  btn-danger" data-bs-dismiss="modal" aria-label="Close">

                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="allocation_id" id="edit-id3">
                            <div class="col-12 mb-1">
                                <label for="">Truck</label>
                                <input type="" disabled class="form-control" name="name" id="edit-plate1">

                            </div>
                            <div class="col-12 mb-1">
                                <div class="form-group">
                                    <label class="col-form-label col-sm-3">Available Trailer: </label>
                                    <select name="trailer_id" class="select2 form-control">
                                        {{-- @php
                                            $trailers = App\Models\Trailer::get();
                                        @endphp
                                        @foreach ($trailers as $trailer)
                                            <option value="{{ $trailer->id }}">{{ $trailer->plate_number }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="assign_trailer_btn" class="btn btn-main">change
                                    Trailer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- / --}}
        {{-- For Assign Trailer Loader --}}
        <script>
            $("#trailer-form").submit(function(e) {
                // e.preventDefault();
                $("#assign_trailer_btn").html("<i class='ph-spinner spinner me-2'></i> Changing Trailer...").addClass(
                    'disabled');
            });
        </script>
    </div>
    {{-- For Edit Cost  --}}
    <div class="modal fade" id="add_payment" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <form method="POST" id="offloading_form" action="{{route('insurance_monthly_payment')}}" onsubmit="return validateForm()"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title lead" id="edit-modal-label">Payment for : <input type="text" class=""
                                id="customer_name" disabled></h6>

                        {{-- <p class="modal-title lead" id="edit-modal-label">Monthly Payment: </p> --}}
                        <button type="button" class="btn-close btn-danger text-light" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <input type="hidden" name="id" id="edit-id1">
                            <div class="form-group col-lg-6">
                                <label class="col-form-label col-sm-3">From </label>
                                <input type ='date' class="form-control" name="from_date" id="from_date">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-form-label col-sm-3">To </label>
                                <input type ='date' class="form-control" name="end_date" id="end_date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for=""><b>Required Monthly Payment</b></label>
                                <input type="text" step="any" required name="quantity"
                                    id="monthly_payment" placeholder="Enter Quantity" class="form-control" disabled>
                            </div>

                            <div class="col-lg-6">
                                <label for="">Amount</label>
                                <input type="number" min="0" step="any" required name="payment_amount"
                                    id="edit-quantity1" placeholder="Enter Amount" class="form-control">

                                <input type="hidden" name="application_id" id="new_application_id"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Attachment</label>
                            <input type="file" name="attachment" class="form-control" id="pod">
                            <p id="fileError" style="color: red;"></p>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="offloading_btn" class="btn btn-success"> <i
                                class="ph ph-check"></i>Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- / --}}




    {{-- For Loading Truck --}}
    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent()
                });
            })
        });
        $(document).ready(function() {
            // Select the button and div by their IDs
            var toggleButton = $("#toggleButton");
            var hiddenDiv = $("#hiddenDiv");

            // Add a click event listener to the button
            toggleButton.click(function() {
                // Toggle the visibility of the div
                hiddenDiv.toggleClass("d-none");
            });
        });
    </script>
    <script>
        $(document).on('click', '.add-payment', function() {
            var id = $(this).data('application_id');
            console.log('application_id = '+id);

            $('#new_application_id').val(id);
        });
    </script>

    <script>
        $(document).on('click', '.edit-driver', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var truck = $(this).data('truck');
            var description = $(this).data('description');

            $('#edit-id2').val(id);
            $('#edit-plate').val(name);
            $('#edit-truck2').val(truck);
            $('#edit-description2').val(description);
        });
    </script>
    <script>
        // For Cancelling or Deleting Allocation
        function removeTruck(id) {

            Swal.fire({
                text: 'Are You Sure You Want to Remove This Truck ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes,Remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var truckid = id;

                    $.ajax({
                            url: "{{ url('trips/remove-truck/') }}/" + truckid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-warning">DISAPPROVED</span></div>'
                                );
                            });

                            // alert('Request Cancelled Successifully!! ...');

                            Swal.fire(
                                'Deleted !',
                                'Allocation Request was Deleted Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Allocation Disapproval Failed!! ....',
                                'success'
                            )

                        });
                }
            });


        }
    </script>


    <script>
        function validateForm() {
            var fileInput = document.getElementById('pod');
            var fileError = document.getElementById('fileError');

            // Check if a file is selected
            if (fileInput.files.length === 0) {
                fileError.textContent = 'Please select a file.';
                $("#offloading_btn").html("Offload")
                    .removeClass('disabled');
                return false; // Prevent form submission
            }

            // Check file size (20.9 MB)
            var maxSize = 20.9 * 1024 * 1024; // 5 MB in bytes
            if (fileInput.files[0].size > maxSize) {
                fileError.textContent = 'File size exceeds 20 MB.';
                $("#offloading_btn").html("Offload")
                    .removeClass('disabled');
                return false; // Prevent form submission
            }

            // Check allowed file types
            var allowedTypes = ['docx', 'pdf', 'jpg', 'jpeg', 'png'];
            var fileType = fileInput.files[0].name.split('.').pop().toLowerCase();
            if (allowedTypes.indexOf(fileType) === -1) {
                fileError.textContent = 'Invalid file type. Allowed types: ' + allowedTypes.join(', ');
                $("#offloading_btn").html("Offload")
                    .removeClass('disabled');
                return false; // Prevent form submission

            }

            // Clear any previous error message
            fileError.textContent = '';


            // Allow form submission
            return true;
        }
    </script>

    <script>
        $(document).on('click', '.edit-trailer', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var truck = $(this).data('truck');
            var description = $(this).data('description');

            $('#edit-id3').val(id);
            $('#edit-plate1').val(name);
            $('#edit-truck1').val(truck);
            $('#edit-description2').val(description);
        });
    </script>

    <script>
        $(document).on('click', '.offload-button', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var truck = $(this).data('truck');
            var description = $(this).data('description');
            var loaded = $(this).data('loaded');
            var quantity = $(this).data('quantity');

            $('#edit-id1').val(id);
            $('#customer_name').val(name);
            $('#edit-truck1').val(truck);
            $('#edit-description1').val(description);
            $('#edit-loaded').val(loaded);
            $('#edit-quantity1').val(quantity);
        });
    </script>

    {{-- For Loading --}}
    <script>
        $("#loading_form").submit(function(e) {
            $("#loading_btn").html("<i class='ph-spinner spinner me-2'></i> Loading ...")
                .addClass('disabled');
        });
    </script>

    {{-- For Offloading  --}}
    <script>
        $("#offloading_form").submit(function(e) {
            $("#offloading_btn").html("<i class='ph-spinner spinner me-2'></i> Paying...")
                .addClass('disabled');
        });
    </script>
    {{-- For Remark Disappear --}}
    <script>
        $(document).ready(function() {
            $("#remark").slideDown(60000).delay(50000).slideUp(300);
            // $("#remark").hide();
        });
    </script>
    {{-- For Complete Trip --}}

    <script>
        $("#complete_btn").Onlick(function(e) {
            $("#complete_btn").html("<i class='ph-spinner spinner me-2'></i> Completing Trip ...")
                .addClass('disabled');
        });
    </script>
    <script>
        function fetchApplication(value) {
            $.ajax({
                type: "GET",
                url: "{{ route('fetch-application-details') }}",
                data: {
                    id: value
                },
                success: function(response) {
                    console.log(response.application.monthly_payment);
                    $("#customer_name").val(response.application.customer.first_name + ' ' + response.application.customer.last_name);
                    $("#monthly_payment").val('Tsh ' + response.application.monthly_payment);
                }
            });

        }
    </script>
@endsection
