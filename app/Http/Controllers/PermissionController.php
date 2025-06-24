<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\SystemModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    public function __construct()
    {


    }

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
    {  // , compact('permissions', 'modules')

        // $this->authenticateUser('view-Permission');

        $permissions = Permission::all();
        $modules = SystemModule::all();
        return view('access-control.permission.index', [
            'permissions' => $permissions,
            'modules' => $modules,
            'parent' => 'Setting',
            'child' => 'Permissions',
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $permission = Permission::create([
            'slug' => str_replace(' ', '-', $request->slug),
            'sys_module_id' => $request->module_id,
        ]);
        $user = Auth::user();
        $current_user_role = $user->roles->first();

        $current_user_role->permissions()->attach($permission->id);

        return back()->with('success', 'Permission added successfully!!!');
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $role = Permission::find($request->id);
        $role->slug = str_replace(' ', '-', $request->slug);
        $role->sys_module_id = $request->module_id;
        $role->save();
        return redirect(route('permissions.index'));
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission_deletion_check = $permission->delete();
        if ($permission_deletion_check) {
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return 'The deletion failed!!!';
        }       
         return redirect(route('permissions.index'));
    }
}
