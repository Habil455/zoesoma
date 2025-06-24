<?php

namespace App\Http\Controllers;

use App\Models\CommissionConfiguration;
use App\Models\CommissionPayment;
use App\Models\InsuranceApplication;
use App\Models\InsurancePayment;
use App\Models\PaymentType;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function confirm_commission(Request $request)
    {
        //
        // return $request->all();
        try {
            //code...
            $commission_item= CommissionPayment::where('id', $request->item_id)->first();

        $commission_item->update([
            'status' => 2,
        ]);

        return back()->with('success', 'Commission Payment Confirmed Successfully');
        } catch (\Exception $e) {

            return back()->with('error', 'Something went wrong, please try again '.$e);
            //throw $th;
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function individual_commissions_payment()
    {
        //
        $data['commissions_payment'] = DB::table('commission_payments')
        ->select(
            'employees.fname as first_name',
            'employees.lname as last_name',
            DB::raw('COALESCE(SUM(commission_payments.amount), 0) as total_commission'),
            'commission_payments.payment_date',
            'commission_payments.approved_by'
        )
        ->join('insurance_payments', 'commission_payments.payment_id', '=', 'insurance_payments.id')
        ->join('insurance_applications', 'insurance_applications.id', '=', 'insurance_payments.application_id')
        ->join('customers', 'customers.id', '=', 'insurance_applications.customer_id')
        ->join('employees', 'employees.id', '=', 'commission_payments.user_id')
        ->where('insurance_payments.payment_type', 1)
        ->where('commission_payments.user_id', Auth::user()->id)
        ->groupBy('commission_payments.payment_date', 'commission_payments.user_id', 'employees.fname', 'employees.lname', 'commission_payments.approved_by')
        ->get();

    return view('commission.payments.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function all_commissions_payment()
    {
        //
        $data['unconfirmed_commissions'] = CommissionPayment::where('status', 1)->get();
        $data['completed_commissions'] = CommissionPayment::where('status', 2)->get();

        // $data['all_commissions_payment'] = DB::table('commission_payments')
        // ->select(
        //     'employees.fname as first_name',
        //     'employees.lname as last_name',
        //     DB::raw('COALESCE(SUM(commission_payments.amount), 0) as total_commission'),
        //     'commission_payments.payment_date',
        //     'commission_payments.approved_by'
        // )
        // ->join('insurance_payments', 'commission_payments.payment_id', '=', 'insurance_payments.id')
        // ->join('insurance_applications', 'insurance_applications.id', '=', 'insurance_payments.application_id')
        // ->join('customers', 'customers.id', '=', 'insurance_applications.customer_id')
        // ->join('employees', 'employees.id', '=', 'commission_payments.user_id')
        // ->where('insurance_payments.payment_type', 1)
        // ->groupBy('commission_payments.payment_date', 'commission_payments.user_id', 'employees.fname', 'employees.lname', 'commission_payments.approved_by')
        // ->get();

        $data['total_commission'] = DB::table('commission_payments')->sum('amount');
        $data['total_pending_commission'] = DB::table('commission_payments')->where('status', 1)->sum('amount');
        $data['confirmed_commissions'] = DB::table('commission_payments')->where('status', 2)->sum('amount');
        return view('commission.payments.all_commission', $data);
    }

    public function index_configuration()
    {
        $data['commission_configs'] = CommissionConfiguration::get();
        $data['payment_types'] = PaymentType::get();
        $data['roles'] = Role::get();
        return view('commission.configuration.index', $data);
    }

    public function store_configuration(Request $request)
    {
        $validate = Validator::make($request->all(), [
            // 'commission_type' => 'required',
            'payment_type' => 'required',
            'role_id' => 'required',
            'commission_amount' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors()->all(),
            ]);
        } else {
            $commission = new CommissionConfiguration();
            // $commission->commission_type = $request->commission_type;
            $commission->payment_type_id = $request->payment_type;
            $commission->role_id = $request->role_id;
            $commission->amount = $request->commission_amount;
            $commission->added_by = auth()->user()->id;
            $commission->save();

            return response()->json([
                'status' => 200,
                'message' => 'Commission Configuration Created Successfully',
            ]);
        }
    }

    public function paymentTypeFilter(Request $request){
        $payment_type = PaymentType::where('id', $request->id)->first();

    return response()->json([
        'amount' => $payment_type ? $payment_type->amount : 0,
        'payment_type_id' => $payment_type ? $payment_type->id : 0
    ]);
    }
}
