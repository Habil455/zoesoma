<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['departments'] = Department::get();
        return view('department.index', $data);
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
        request()->validate(
            [
                'name' => 'required|string',
            ]
        );

        $department = Department::create([
            'name' =>$request->name,
            'type' =>1,
            'state' =>1
        ]);

        $route_departments = route('department.index');
        return response()->json([
            'status' => 200,
            'route_departments' => $route_departments,
        ]);
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
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return back()->with('error', 'Department not found');
        }

        $department->delete();

        return back()->with('success', 'Department deleted successfully');
    }
}
