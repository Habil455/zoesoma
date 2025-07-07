<?php

namespace App\Http\Controllers;

use App\Helpers\SysHelpers;
use App\Models\Customer;
use App\Models\CustomerBeneficiary;
use App\Models\IdentificationType;
use App\Models\InsuranceApplication;
use App\Models\InsuranceType;
use App\Models\Overseer;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $my_freelancers = User::where('added_by', Auth::user()->id)
                      ->whereHas('customers')
                      ->get();
        $data['freelancer_customers'] = [];

        foreach ($my_freelancers as $freelancer) {
            $data['freelancer_customers'][] = Customer::where('created_by', $freelancer->id)->get();
        }

        $data['customers'] = Customer::where('type', 1)->where('created_by', Auth::user()->id)->get();

        return view('customers.index', $data);
    }
    public function all_registration()
    {
        //
        $data['all_customers'] = Customer::where('type', 1)->get();
        return view('customers.all_registrations', $data);
    }
    public function all_public_sector_registrations()
    {
        //
        $data['all_customers'] = Customer::where('type', 2)->get();
        return view('customers.public_sector.all_public_sector_registrations', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['Insurance_types'] = InsuranceType::get();
        $data['identification_types'] = IdentificationType::get();
        $data['regions'] = Region::get();
        return view('customers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->moreBeneficiaries);
        $validate = Validator::make($request->all(), [
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'district' => 'required',
            'region' => 'required',
            'birthdate' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors()->all(),
            ]);
        }

        $existing_customer = Customer::where('first_name', $request->fname)
                                     ->where('middle_name', $request->mname)
                                     ->where('last_name', $request->lname)->first();
        if($existing_customer){
            return back()->with('error', 'Customer is existing, Try Registering another');
        }

        DB::beginTransaction();

        try {
            $lastCustomer = Customer::orderBy('id', 'desc')->first();
            $nextNumber = $lastCustomer ? $lastCustomer->id + 1 : 1;
            $username = $request->fname . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            $password  = Str::random(8);

            $customer = new Customer();
            $customer->first_name = $request->fname;
            $customer->middle_name = $request->mname;
            $customer->last_name = $request->lname;
            $customer->phone_number = $request->phone;
            $customer->email = $request->email;
            $customer->date_of_birth = $request->birthdate;
            $customer->gender = $request->gender;
            $customer->region_id = $request->region;
            $customer->district_id = $request->district;
            $customer->occupation = $request->occupation;
            $customer->address = $request->address;
            $customer->id_type = $request->idtype;
            $customer->id_number = $request->cust_id_no;
            $customer->created_by = auth()->user()->id;
            $customer->type = $request->customer_type ?? 1;// Default to 1 if not set
            // creating the customer credentials

            $customer->save();

            $total_beneficiaries = count($request->moreBeneficiaries);

            foreach ($request->moreBeneficiaries as $key => $value) {
                $beneficiary = new CustomerBeneficiary();
                $beneficiary->customer_id = $customer->id;
                $beneficiary->first_name = $value['benef_fname'];
                $beneficiary->last_name = $value['benef_lname'];
                $beneficiary->phone_number = $value['benef_phone'];
                $beneficiary->relationship = $value['benef_relation'];
                $beneficiary->id_type = $value['benef_idtype'] ?? null;
                $beneficiary->id_number = $value['benef_id_no'] ?? null;
                $beneficiary->save();
            }

            $overseer = new Overseer();
            $overseer->customer_id = $customer->id;
            $overseer->first_name = $request->overseer_fname;
            $overseer->last_name = $request->overseer_lname;
            $overseer->phone_number = $request->overseer_phone;
            $overseer->relationship = $request->overseer_relation;
            $overseer->id_type = $request->overseer_idtype ?? null;
            $overseer->id_number = $request->overseer_id_no ?? null;
            $overseer->save();

            // Extract insurance term number
            $term_number = 0;
            if (preg_match('/\d+/', $request->insurance_term, $matches)) {
                $term_number = (int)$matches[0];
            }

            $insurance_application = new InsuranceApplication();
            $insurance_application->customer_id = $customer->id;
            $insurance_application->insurance_type = $request->insurance_purpose;
            $insurance_application->insurance_term = null;
            $insurance_application->total_beneficiaries = $total_beneficiaries;
            $insurance_application->monthly_payment = $request->monthly_fee;
            $insurance_application->expected_amount = intval($request->monthly_fee * 12 * $term_number);
            $insurance_application->created_by = Auth::user()->id;
            $insurance_application->save();

            // Create user credentials for the customer
            $credentials = Customer::find($customer->id);
            $credentials->username = $username;
            $credentials->password = Hash::make($password);
            $credentials->update();


            $message = "Hi {$customer->first_name} {$customer->last_name}, your ZoeSoma account has been created. \nUsername: {$username},\nPassword: {$password}. \nPlease change your password after login. \n link: www.zoesomaconsultancy.com/customer";
            // dd($message);
            $phone = $credentials->phone_number;
            $new_phone = str_replace(' ', '', $phone);
            $this->sendSMS($new_phone, $message);

            DB::commit(); // ✅ All operations succeeded

            return back()->with('success', 'Customer Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Something went wrong, rollback everything
            dd($e);
            return back()->with('error', 'Failed to create customer: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data['customer_details'] = Customer::where('id', $id)->first();
        $data['regions'] = Region::get();
        $data['id_types'] = IdentificationType::get();
        return view('customers.show', $data);
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
        $customer_details = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'occupation' => $request->occupation,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'region_id' => $request->region_id,
            'district_id' => $request->district,
            'date_of_birth' => $request->birthdate,
            'id_type' => $request->id_type,
            'id_number' => $request->id_no,
        ];

        $customer = Customer::where('id', $id)->first();
        $customer->update($customer_details);
        $customer->save();
        return back()->with('success', 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $customer = Customer::where('id', $id)->first();
        // dd($customer);
        $customer_delete = $customer->delete();

        if($customer_delete){
            return response()->json([
                'status'=>200,
            ]);
        }
        else{
            return 'The deletion failed!!!';
        }
    }

    public function public_customers(){
        $data['customers'] = Customer::where('type', 2)->where('created_by', Auth::user()->id)->get();
        return view('customers.public_sector.index', $data);
    }

     public function public_customers_create()
    {
        //
        $data['Insurance_types'] = InsuranceType::where('id', 4)->get();
        $data['identification_types'] = IdentificationType::get();
        $data['regions'] = Region::get();
        return view('customers.public_sector.create', $data);
    }


    public static function sendSMS($phone, $message){
        // return Http::withOptions([
        //     'verify' => false, // Disable SSL verification
        // ])->post('https://mshastra.com/sendsms_api_json.aspx', [
        //     'user' => 'ZOESOMA',
        //     'pwd' => 'p9s_e1_6',
        //     'senderid' => 'Mobishastra',
        //     'mobileno' => $phone,
        //     'msgtext' => $message,
        //     'CountryCode' => '+255',
        // ]);

        $baseUrl = 'https://mshastra.com/sendurl.aspx';
        $query = [
            'user'       => 'ZOESOMA',
            'pwd'        => 'zoe@1909',
            // 'senderid'   => 'Mobishastra',
            'senderid'   => 'ZoesomaLtd',
            'mobileno'   => $phone,
            'msgtext'    => $message,
            'CountryCode'=> '+255',
        ];

        // disable SSL verification if needed (equivalent to curl -k)
        $response = Http::withOptions(['verify' => false])
                        ->get($baseUrl, $query);

        if ($response->successful()) {
            return 'SMS sent: ' . $response->body();
        }

        return 'Error: ' . $response->status() . ' - ' . $response->body();
    }

}
