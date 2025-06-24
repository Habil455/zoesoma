<?php

namespace App\Http\Controllers;

use App\Models\CommissionConfiguration;
use App\Models\CommissionPayment;
use App\Models\CommissionPaymentRemark;
use App\Models\InsuranceApplication;
use App\Models\InsurancePayment;
use App\Models\InsuranceType;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTypes()
    {
        //
        $data['insurance_types'] = InsuranceType::get();
        return view('insurance.types.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function storeTypes(Request $request)
    {
        //

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'duration_years' => 'required',
            'price' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors()->all(),
            ]);
        }

        else{
            $amount = $request->price;
            $cleanNumber = str_replace(',', '', $amount);
            $new_amount = doubleval($cleanNumber);
            $insurance = new InsuranceType();
            $insurance->name = $request->name;
            $insurance->duration_year = $request->duration_years;
            $insurance->duration_days = $request->duration_years * 365;
            $insurance->price = $new_amount;
            $insurance->created_by = auth()->user()->id;
            $insurance->save();

            return response()->json([
                'status' => 200,
                'message' => 'Insurance Type Created Successfully',
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function insurance_filter(Request $request)
    {
        //
        if($request->ajax()){
            $insurance = InsuranceType::where('id', $request->id)->first();
            return json_encode($insurance);
        }
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        //
        $data['applications'] = InsuranceApplication::where('created_by', Auth::user()->id)->get();
        return view('insurance.application.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function application_fee_payment(Request $request)
    {
        //
        $application = InsuranceApplication::where('id', $request->application_id)->first();

        if($application->status == 3){
            return back()->with ('error', 'Insurance Application Fee Already Paid');
        }

        $payment_amount = $request->amount;

        if (preg_match('/\d+/', $payment_amount, $matches)) {
            $amount = (int)$matches[0]; // Result: 5
        }

        $insurance_payment = new InsurancePayment();
        $insurance_payment->application_id = $application->id;
        $insurance_payment->description = 'Received Insurance Fee Payment for '. $application->insuranceType->name. ' from '. $application->customer->first_name. ' '. $application->customer->last_name;
        $insurance_payment->payment_amount = $amount;
        $insurance_payment->payment_date = now();
        $insurance_payment->status = 1;
        $insurance_payment->payment_type = $request->payment_type_id;
        $insurance_payment->created_by = auth()->user()->id;
        $insurance_payment->save();

        if($insurance_payment){
            $application->status = 2;
            $application->update();

            return back()->with ('success', 'Insurance Application Fee Paid Successfully');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function education_insurance_requests()
    {
        //

        // Active : Application status = 3
        // Waiting for approval = 2
        // Inactive = 1

        $data['application_requests'] = InsuranceApplication::where('insurance_type', 1)
                                                                ->where('status', 2)->get();
        $data['active_applications'] = InsuranceApplication::where('insurance_type', 1)
                                                                ->where('status', 3)->get();
        $data['total_pending_requests'] = InsuranceApplication::where('insurance_type', 1)
                                                        ->where('status', 2)->count();
        $data['total_active_applications'] = InsuranceApplication::where('insurance_type', 1)
                                                        ->where('status', 3)->count();
        return view('insurance.application.education_requests', $data);

    }

    public function bodaboda_insurance_requests()
    {

        $data['application_requests'] = InsuranceApplication::where('insurance_type', 2)
                                                                ->where('status', 2)->get();
        $data['active_applications'] = InsuranceApplication::where('insurance_type', 2)
                                                                ->where('status', 3)->get();
        $data['total_pending_requests'] = InsuranceApplication::where('insurance_type', 2)
                                                        ->where('status', 2)->count();
        $data['total_active_applications'] = InsuranceApplication::where('insurance_type', 2)
                                                        ->where('status', 3)->count();
        return view('insurance.application.bodaboda_requests', $data);

    }

    public function business_insurance_requests()
    {

        $data['application_requests'] = InsuranceApplication::where('insurance_type', 3)
                                                                ->where('status', 2)->get();
        $data['active_applications'] = InsuranceApplication::where('insurance_type', 3)
                                                                ->where('status', 3)->get();
        $data['total_pending_requests'] = InsuranceApplication::where('insurance_type', 3)
                                                        ->where('status', 2)->count();
        $data['total_active_applications'] = InsuranceApplication::where('insurance_type', 3)
                                                        ->where('status', 3)->count();
        return view('insurance.application.business_requests', $data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function approve_insurance_requests(Request $request){
    DB::beginTransaction();
    try {
        $application = InsuranceApplication::with(['users.roles', 'customer'])->findOrFail($request->application_id);

        // if($application->customer->type == 2){
        //     return back()->with('error', 'Public Sector Customers are not allowed to apply for Insurance');
        // }
        $insurance_payment = InsurancePayment::where('application_id', $application->id)
            ->where('payment_type', 1)
            ->firstOrFail();

        $commissions_configs = CommissionConfiguration::where('payment_type_id', 1)
            ->with('roles')
            ->get();

        $creator_role_id = $application->users->roles->first()->id;

        $currentUser = Auth::user();
        $currentRoleName = $currentUser->roles->first()->name;

        if($application->customer->type ==1){
            // Normal customer
            foreach ($commissions_configs as $commission) {
                if ($creator_role_id == 2) {
                    // Application created by Supervisor
                    $user_id = $application->created_by;
                } elseif ($creator_role_id == 3) {
                    // Application created by Freelancer
                    if ($commission->roles->id == 3) {
                        $user_id = $application->customer->created_by; // freelancer
                    } else {
                        $freelancer = User::findOrFail($application->customer->created_by);
                        $user_id = $freelancer->added_by; // supervisor
                    }
                } else {
                    continue; // Skip if neither freelancer nor supervisor
                }

                // Create commission payment
                $commission_payment = CommissionPayment::create([
                    'payment_id' => $insurance_payment->id,
                    'configuration_id' => $commission->id,
                    'user_id' => $user_id,
                    'approved_by' => $currentUser->id,
                    'amount' => $commission->amount,
                    'payment_date' => now(),
                    'status' => 1,
                ]);


            // Create remark
            CommissionPaymentRemark::create([
                'commission_payment_id' => $commission_payment->id,
                'remarked_by' => $currentRoleName,
                'remark' => $request->reason,
                'created_by' => $currentUser->id,
            ]);
        }
    }

        // Update application status
        $application->update(['status' => 3]);

        DB::commit();
        return back()->with('success', 'Insurance Application Approved Successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Approval failed: ' . $e->getMessage(), ['exception' => $e]);
        return back()->with('error', 'Failed to Approve the Insurance Application '. $e->getMessage());
    }
}

    public function view_insurance_application($id)
    {
        //
        $data['application'] = InsuranceApplication::where('id', $id)->first();
        $data['insurance_payment'] = InsurancePayment::where('application_id', $id)->where('payment_type', 2)->get();
        // return $data['application'];
        return view('insurance.application.show', $data);
    }

    public function fetch_application_details(Request $request)
    {
        //
        if($request->ajax()){
            $application = InsuranceApplication::with('customer')->where('id', $request->id)->first();
            return response()->json([
                'status' => 200,
                'application' => $application
            ]);
        }
    }


    public function monthly_insurance_payment(Request $request)
    {
        if (!empty($request->from_date)) {
            $startDate = $request->input('from_date') . ' 00:00:00';
            $endDate = $request->input('end_date') . ' 23:59:59';
        } else {
            $startDate = now();
            $endDate = now();
        }

        $new_startDate = Carbon::parse($startDate);
        $new_endDate = Carbon::parse($endDate);

        $duration = $new_startDate->diffInDays($new_endDate);

        $payment_type = PaymentType::where('id', 2)->first();

        $application = InsuranceApplication::find($request->application_id);

        if($request->payment_amount > $application->expected_amount ){
            return back()->with('error', 'Can\'t pay more that the expected amount');
            // COMMISSION PAYMENT
        }else {
            # code...
            $insurance_payment = new InsurancePayment();
            $insurance_payment->application_id = $application->id;
            $insurance_payment->description = 'Received Monthly Payment for '. $application->insuranceType->name. ' from '. $application->customer->first_name. ' '. $application->customer->last_name;
            $insurance_payment->payment_amount = $request->payment_amount;
            $insurance_payment->payment_date = now();
            $insurance_payment->start_date = $startDate;
            $insurance_payment->end_date = $endDate;
            $insurance_payment->duration = $duration;
            $insurance_payment->created_by = Auth::user()->id;
            $insurance_payment->payment_type = $payment_type->id;
            $insurance_payment->status = 1;
            $insurance_payment->save();

            if($insurance_payment){

                // checking if the commission can be paid
                $total_payment = InsurancePayment::where('application_id', $application->id)
                    ->where('payment_type', 2)
                    ->whereMonth('payment_date', Carbon::now()->month)
                    ->sum('payment_amount');
                if($total_payment >= $payment_type->amount){
                    $commissions_configs = CommissionConfiguration::where('payment_type_id', 2)
                        ->with('roles')
                        ->get();

                    $creator_role_id = $application->users->roles->first()->id;

                    $currentUser = Auth::user();
                    $currentRoleName = $currentUser->roles->first()->name;

                    foreach ($commissions_configs as $commission) {
                        if ($creator_role_id == 2) {
                            // Application created by Supervisor
                            $user_id = $application->created_by;
                        } elseif ($creator_role_id == 3) {
                            // Application created by Freelancer
                            if ($commission->roles->id == 3) {
                                $user_id = $application->customer->created_by; // freelancer
                            } else {
                                $freelancer = User::findOrFail($application->customer->created_by);
                                $user_id = $freelancer->added_by; // supervisor
                            }
                        } else {
                            continue; // Skip if neither freelancer nor supervisor
                        }

                        // Create commission payment
                        $commission_payment = CommissionPayment::create([
                            'payment_id' => $insurance_payment->id,
                            'configuration_id' => $commission->id,
                            'user_id' => $user_id,
                            'approved_by' => $currentUser->id,
                            'amount' => $commission->amount,
                            'payment_date' => now(),
                            'status' => 1,
                        ]);

                        // Create remark
                        // CommissionPaymentRemark::create([
                        //     'commission_payment_id' => $commission_payment->id,
                        //     'remarked_by' => $currentRoleName,
                        //     'remark' => 'Monthly Payment',
                        //     'created_by' => $currentUser->id,
                        // ]);
                    }

                    return back()->with('success', 'Succeeded to Pay the Insurance and Commission to Users');
                }


                return back()->with('success', 'Succeeded to Pay the Insurance');
            }
        }

    }

    public function monthly_insurance_commission(Request $request)
    {
        //

    }
}
