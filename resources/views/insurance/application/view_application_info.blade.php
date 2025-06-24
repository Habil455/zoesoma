{{-- This is the page for Trip Details --}}
<div class="row bg-light p-2">
    {{-- Customer Details --}}
    <div class="col-12 col-md-6 border-end">
        <h5 class="text-center"> Customer Details</h5>
        <div class="row d-flex">
            <div class="col-8">
                <p><b class="text-black">Customer Name</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->first_name }} {{ $application->customer->last_name }}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Phone No</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->phone_number }}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Email</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->email ?? 'Not Available'}}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Location</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->region->name }} - {{ $application->customer->district->name }}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Age</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ \Carbon\Carbon::parse($application->customer->date_of_birth)->age}}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Application Date</b></p>
            </div>
            <div class="col-4 text-end">
                <p>{{$application->created_at->format('d/m/Y H:i:s')}}</p>
            </div>


        </div>
    </div>
    {{-- Trip Details --}}
    <div class="col-12 col-md-6">
        <h5 class="text-center"> Other Details</h5>
        <div class="row d-flex">
            <div class="col-6">
                <p><b class="text-black">No of Beneficiries </b> </p>
            </div>
            <div class="col-6 text-end">
                <p>{{ $application->total_beneficiaries}}</p>
            </div>
            {{--  --}}

            <div class="col-8">
                <p><b class="text-black">Overseer Name</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->overseers->first_name ?? 'Not Available'}} {{ $application->customer->overseers->last_name ?? 'Not Available'}}</p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">Overseer Phone</b> </p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->overseers->phone_number ?? 'Not Available'}}</p>
            </div>
            {{--  --}}

            <div class="col-8">
                <p><b class="text-black">Relationship</b></p>
            </div>
            <div class="col-4 text-end">
                <p>{{ $application->customer->overseers->relationship ?? 'Not Available'}}</p>
                </p>
            </div>
            {{--  --}}
            <div class="col-8">
                <p><b class="text-black">ID Details</b> </p>
            </div>
            <div class="col-4 text-end">
                <p> {{ $application->customer->overseers->id_types->name ?? 'Not Available'}}:{{ $application->customer->overseers->id_number ?? 'Not Available' }} </p>
                </p>
            </div>
            {{--  --}}

            {{--  --}}


        </div>
    </div>
</div>
