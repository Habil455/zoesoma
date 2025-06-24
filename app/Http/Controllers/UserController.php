<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Department;
use App\Models\District;
use App\Models\IdentificationType;
use App\Models\Position;
use App\Models\Region;
use App\Models\User;
use App\Notifications\RegisteredUser;
use Database\Seeders\UserSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard(){

        $data['total_supervisors'] = User::whereHas('positions', function ($query) {
            $query->whereNot('name', 'Freelancer');
        })->with('positions')->count();
        $data['total_freelancers'] = User::whereHas('positions', function ($query) {
            $query->where('name', 'Freelancer');
        })->with('positions')->count();
        $data ['total_customers'] = Customer::count();
        $data['total_users'] = User::count();
        return view('dashboard', $data);

    }

    public function index()
    {
        // $data['users'] = User::with('region', 'district')->get();
        $data['staffs'] = User::whereHas('positions', function ($query) {
            $query->where('name', 'Staff');
        })->with('positions')->get();
        $data['freelancers'] = User::whereHas('positions', function ($query) {
            $query->where('name', 'Freelancer');
        })->with('positions')->get();
        // return $data['freelancers'];
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['departments'] = Department::get();
        $data['regions'] = Region::get();
        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'fname' => 'required ',
            'mname' => 'required ',
            'lname' => 'required ',
            'phone' => 'required ',
            'email' => 'required ',
            'position' => 'required ',
            'address' => 'required ',
            'region' => 'required '
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors()->all(),
            ]);
        }

        $check_existence = User::where('fname', $request->fname)
                                     ->where('mname', $request->mname)
                                     ->where('lname', $request->lname)->first();
        if($check_existence){
            return back()->with('error', 'Freelancer is existing, Try Registering another');
        }

        else{

            // DB::beginTransaction();
            // dd($request->all());
            $password = 'ZoeSoma@2025';
            $user = new User();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->department_id = $request->department;
            $user->position = $request->position;
            $user->merital_status = $request->merital_status;
            $user->address = $request->birthdate;
            $user->region_id = $request->region;
            $user->district_id = $request->district;
            $user->password = Hash::make($password);
            $user->hire_date = $request->contract_start;
            $user->joining_date =$request->contract_end;
            $user->added_by = Auth::user()->id;
            $user->gender = $request->gender;
            $user->address = $request->address;

            $user->save();

            $user = User::find($user->id);
            $user->user_code = 'ZS'.date('y').str_pad($user->id, 3, '0', STR_PAD_LEFT);
            // $user->user_code = 'ZS'.date('y').date('m').$user->id;
            $user->update();

            $position = Position::where('id', $user->position)->first();
            if($position->name == 'Freelancer'){
                $user->roles()->attach(3);
            }
            elseif($position->name == 'Staff'){
                $user->roles()->attach(2);
            }


            $employees = User::where('id', $user->id)->get();

            $credentials = [
                'username' => $user->user_code,
                'password' => $password,
            ];

            $email_data = array(
                    'subject' => 'ZOESOMA User Credentials',
                    'view' => 'emails.credentials',
                    'credentials' => $credentials,
            );


            $job = (new \App\Jobs\SendEmail($email_data, $employees));
            dispatch($job);

            if ($job == true) {
                return back()->with('success', 'User Created Successfully');
            } else {
                return back()->with('error', 'Failed to send email');
            }
            // DB::commit();

        }
    }

    /**
     * Display the specified resource.
     */
    public function indexIds()
    {
        //
        $data['ids'] = IdentificationType::get();
        return view('identifications.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function storeIds(Request $request)
    {
        //
        $validate = Validator::make($request->all(), [
            'name' => 'required ',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->errors()->all(),
            ]);
        }
        else{
            $id = new IdentificationType();
            $id->name = $request->name;
            $id->save();
            return response()->json([
                'status' => 200,
                'message' => 'Identification Type Created Successfully',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function all_position(Request $request)
    {
        // $this->authenticateUser('view-organization');
        $data['departments'] = Department::get();
        $data['position'] = Position::get();
        // $data['levels'] = $this->flexperformance_model->getAllOrganizationLevel();
        // $data['position'] = $this->flexperformance_model->position();
        // $data['inactive_position'] = $this->flexperformance_model->inactive_position();
        $data['title'] = "Position";
        return view('department.position', $data);
    }


    public function add_position(Request $request)
    {
        if ($request->method() == "POST") {

            $data = array(
                'name' => $request->input('name'),
                'dept_id' => $request->input('department'),
                'created_by' =>Auth::user()->id
            );

            $result = Position::create($data);
            if ($result == true) {
                return back()->with('success', 'Position Added Successfully');

                // $autheniticateduser = auth()->user()->emp_id;
                // $auditLog = SysHelpers::AuditLog(1, "Position added  by " . $autheniticateduser, $request);



                //$response_array['status'] = "OK";
                // $response_array['message'] = "<p class='text-center alert alert-success'>Position Added Successifully!</p>";
            } else {
                $response_array['status'] = "ERR";
                $response_array['message'] = "<p class='text-center alert alert-danger'>FAILED: Position NOT Deleted!</p>";
            }
            header('Content-type: application/json');
            echo json_encode($response_array);
        }
    }


    public function districtFilters(Request $request){
        if($request->ajax()){
            $district = District::where('region_id', $request->id)->get();
            return json_encode($district);
        }
    }
    public function positionFilters(Request $request){
        if($request->ajax()){
            $position = Position::where('dept_id', $request->id)->get();
            return json_encode($position);
        }
    }

    public function delete_position(){

    }

    public function resend_credentials($options, $id)
    {
        if ($options == 'single') {
            $user = User::where('id', $id)->first();

            if (!$user) {
                return back()->with('error', 'User not found.');
            }

            $credentials = [
                'username' => $user->user_code,
                'password' => 'ZoeSoma@2025',
            ];

            $email_data = [
                'subject' => 'ZOESOMA User Credentials',
                'view' => 'emails.credentials',
                'credentials' => $credentials,
            ];

            $result = $this->email_job($email_data, [$user]); // Passing the user as an array for consistency
            if ($result) {
                return back()->with('success', 'Credentials sent successfully');
            } else {
                return back()->with('error', 'Failed to send email');
            }
        } else {
            $users = User::all(); // Get all users

            if ($users->isEmpty()) {
                return back()->with('error', 'No users found.');
            }

            foreach ($users as $user) {
                $credentials = [
                    'username' => $user->user_code,
                    'password' => 'ZoeSoma@2025',
                ];

                $email_data = [
                    'subject' => 'ZOESOMA User Credentials',
                    'view' => 'emails.credentials',
                    'credentials' => $credentials,
                ];

                $result = $this->email_job($email_data, [$user]); // Passing each user as an array to the job
            }

            return back()->with('success', 'Credentials sent to all users successfully');
        }
    }

    public function email_job($email_data, $employees)
    {
        $job = (new \App\Jobs\SendEmail($email_data, $employees));
        dispatch($job);
        return $job;
    }

    public function destroy(string $id){
        $user = User::where('id', $id)->first();
        // dd($user);
        $user_delete = $user->delete();

        if($user_delete){
            return response()->json([
                'status'=>200,
            ]);
        }
        else{
            return 'The deletion failed!!!';
        }
    }
}
