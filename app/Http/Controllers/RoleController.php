<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\SystemModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class RoleController extends Controller
{

    public function authenticateUser($permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }



        if(!Auth::user()->can($permissions)){

          abort(Response::HTTP_UNAUTHORIZED,'500|Page Not Found');

         }

    }

    public function index()
    {

        // $this->authenticateUser('view-roles');
        $roles = Role::all();
        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-control.role.index', compact('roles', 'permissions', 'modules'));
    }

    public function create(Request $request)
    {
// dd("kk");
        $role = Role::find($request->role_id);
      //  if($role->added_by == auth()->user()->id){
        if (isset($request->permissions)) {
            $role->refreshPermissions($request->permissions);
        } else {
            $role->permissions()->detach();
        }
        $message = "permission updated successfully";
        $type = "success";
    //    }else{
    //        $message = "You dont have permission to perform this action";
    //        $type = "error";
    //    }

        return redirect()->back()->with([$type=>$message]);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $role = Role::create([
            'slug' => str_replace(' ', '-', $request->slug),
            'name' => $request->slug,
            'added_by'=>auth()->user()->id,

        ]);
        return redirect(route('roles.index'));
    }

    public function show($id)
    {

        $role = Role::find($id);
        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-control.role.assign', compact('permissions', 'modules', 'role'));
    }


    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($request->id);
        $role->slug = str_replace(' ', '-', $request->slug);
        $role->save();
        return redirect(route('roles.index'));
    }

    public function destroy($id)
    {
        $this->authenticateUser('delete-role');

        $role = Role::find($id);
        $role->delete();
        return redirect(route('roles.index'));
    }
}
