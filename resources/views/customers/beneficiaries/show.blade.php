<div id="modal_large" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Large modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <table class="table table-striped table-boadered datatable-basic">
                <thead>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Relationship</th>
                    <th>ID Type</th>
                    <th>ID Number</th>
                    <th class="text-center">Actions</th>
                </thead>
                <tbody>
                    @forelse($beneficiaries as $data)
                        @php

                            $end_date = \Carbon\Carbon::parse($data->end_date);
                            $start_date = \Carbon\Carbon::parse($data->from_date);
                            $duration = $end_date->diffInDays($start_date);
                            // $trailers = App\Models\TrailerAssignment::where(
                            //     'truck_id',
                            //     $data->truck_id,
                            // )->first();
                            // $drivers = App\Models\User::where('position', '9')->get();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$data->first_name}} {{$data->last_name}} </td>
                            <td>{{$data->phone_number ?? 'Not Available'}}</td>
                            <td>{{ $data->relationship }}</td>
                            <td>{{ $data->identificationType->name ?? 'Not Available' }}</td>
                            <td>{{ $data->id_number ?? 'Not Available' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="#" class="dropdown-item">
                                                <i class="ph ph-pencil me-2"></i>
                                                Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="ph ph-trash me-2"></i>
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @empty
                    @endforelse
                </tbody>

            </table>

            {{-- <div class="modal-body">
					<h6 class="fw-semibold">Text in a modal</h6>
					<p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>

					<hr>

					<h6 class="fw-semibold">Another paragraph</h6>
					<p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
					<p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
				</div> --}}

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
