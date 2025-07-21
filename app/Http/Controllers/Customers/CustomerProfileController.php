<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\InsuranceApplication;
use App\Models\InsurancePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function dashboard()
    {
        //
        $data['total_applications'] = InsuranceApplication::where('customer_id', Auth::guard('customer')->id())->count();
        $data['total_payments'] = DB::table('insurance_payments')
                                    ->join('insurance_applications', 'insurance_payments.application_id', '=', 'insurance_applications.id')
                                    ->where('insurance_applications.customer_id', Auth::guard('customer')->id())
                                    ->sum('insurance_payments.payment_amount');
        $data['total_monthly_payments'] = DB::table('insurance_applications')
                                    ->join('insurance_payments', 'insurance_applications.id', '=', 'insurance_payments.application_id')
                                    ->where('insurance_applications.customer_id', Auth::guard('customer')->id())
                                    ->whereMonth('insurance_payments.created_at', now()->month)
                                    ->sum('insurance_payments.payment_amount');
        $data['total_beneficiaries'] = DB::table('customer_beneficiaries')
                                    ->where('customer_id', Auth::guard('customer')->id())
                                    ->count();
        return view('customers.dashboard', $data);
        // return 'Here is Habil';
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
