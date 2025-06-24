<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\District;
use App\Models\Position;
use App\Models\Region;
use App\Models\SupervisorAssignments;
use App\Models\User;
use App\Notifications\RegisteredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['departments'] = Department::get();
        return view('user.freelancer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function all_assignment()
    {
        //
        $data['staffs'] = User::whereHas('positions', function ($query) {
            $query->where('name', 'Staff');
        })->with('positions')->get();
        // $data['assigned_staffs']= SupervisorAssignments::get();
        // $data['regions'] = Region::get();
        return view('user.freelancer_assignment', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    //     try {
    //         // Validate the request data
    //         $validatedData = $request->validate([
    //             'supervisor_id' => 'required|integer|exists:employees,id',
    //             'district_id' => 'required|integer|exists:districts,id',
    //         ]);

    //         // Find the truck and ensure it exists
    //         $truck = District::find($validatedData['district_id']);
    //         if (!$truck) {
    //             return back()->with('error', 'District not found.');
    //         }

    //         // Create and save the driver assignment
    //         SupervisorAssignments::create([
    //             'supervisor_id' => $validatedData['supervisor_id'],
    //             'district_id' => $validatedData['district_id'],
    //             'assigned_by' => Auth::user()->id,
    //         ]);

    //         DB::commit();

    //         return back()->with('success', 'Supervisor was assigned successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error assigning supervisor: ' . $e->getMessage(), ['exception' => $e, 'request' => $request->all()]);

    //         return back()->with('error', 'An error occurred while assigning supervisor. ' . $e->getMessage());
    //     }
    // }

    /**
     * Display the specified resource.
     */

     public function create()
     {
         //
         $department = Department::where('name', 'Sales')->first();
         $data['regions'] = Region::get();
         $data['position'] = Position::where('dept_id', $department->id)->first();
         return view('user.freelancer.create', $data);
     }

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
        $data['freelancer'] = User::findOrFail($id);
        // return $data['freelancer']->joining_date;
        $data['regions'] = Region::get();
        return view('user.freelancer.edit', $data);
    }

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
            return back()->with('error', 'User is existing, Try Registering another');
        }
        
        else{
            // DB::beginTransaction();
            // dd($request->all());
            $position = Position::where('name', $request->position)->first();
            $password = 'ZoeSoma@2025';
            $user = new User();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->position = $position->id;
            $user->department_id = $position->department->id;
            $user->merital_status = $request->merital_status;
            $user->address = $request->birthdate;
            $user->region_id = $request->region;
            $user->district_id = $request->district;
            $user->password = Hash::make($password);
            $user->hire_date = $request->contract_start;
            $user->joining_date =$request->contract_end;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->added_by = Auth::user()->id;

            $user->save();

            $user = User::find($user->id);
            $user->user_code = 'ZS'.date('y').str_pad($user->id, 3, '0', STR_PAD_LEFT);
            $user->update();

            if($user){
                $user->roles()->attach(3);
            }

            $email_data = array(
                'email' => $request->email,
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $user->user_code,
                'password' => $password,
            );

            $user->notify(new RegisteredUser($email_data));
            Notification::route('mail', $email_data['email'])->notify(new RegisteredUser($email_data));
            return response()->json([
                'status' => 200,
                'message' => 'User Created Successfully',
            ]);
            // DB::commit();

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{

            $user = User::findOrFail($id);

            User::where('id', $user->id)->update([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                // 'position' => $request->position,
                'address' => $request->address,
                'region_id' => $request->region,
                'district_id' => $request->district,
                'gender' => $request->gender,
                'merital_status' => $request->marital_status,
            ]);
            return back()->with('success', 'User updated successfully!');
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while updating the user. ' . $e->getMessage(),
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
