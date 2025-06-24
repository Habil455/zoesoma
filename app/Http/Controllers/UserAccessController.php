<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function authenticateUser($permissions)
    {
        // Check if the user is not authenticated
        if (!auth()->check()) {
            // Redirect the user to the login page
            return redirect()->route('login');
        }

        // Check if the authenticated user does not have the specified permissions
        if (!Gate::allows($permissions)) {
            // If not, abort the request with a 401 Unauthorized status code
            abort(Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function index_users_role()
    {
        // $this->authenticateUser('edit-roles');

        return view('access-control.users.index', [
            'users' => User::all(),
            'parent' => 'Organisation',
            'child' => 'User'
        ]);
    }
    public function edit($id)
    {
        //
        $role = Role::all();
        $region = Region::all();
        //$user = User::with('Role')->where('id',$id)->get();
        $user = User::all()->where('id',$id);
      $users = User::find($id);
        $department = Department::all();
    //  $designation= Designation::where('department_id', $users->department_id)->get();
        return view('access-control.users.edit',Compact('user','role','region','department'));
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user) {

        }
        $user->roles()->detach();
        $user->roles()->attach($request['role']);

        $roles['user_id'] = $user->id;
        $roles['added_by'] = auth()->user()->id;
        $roles['role_id'] = $request['role'];
        return redirect(route('users-role.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
