<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\UserRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $employee = User::find($id);
        if(!$employee){
            return response()->json([
                'message'=> 'Not found',
            ]);
        }
        return response()->json($employee);
    }

    public function store(UserRequest $request)
    {
        if($request->file('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('Employees', $image , 'Users');
            }else{
                $path = NULL;
            }  
        $employee = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'image' => $path,
            'password' => Hash::make($request->password),
            'department_id'=> $request->department_id,
        ]);
        return response()->json([
            'message' => 'User created successfully',
            'user' => $employee
        ]);
    }

    public function show($id)
    {
        $department = Department::withoutTrashed()->find($id);
        return response()->json($department->users->where("type","emp"));
    }

    public function update(Request $request, $id)
    {
        
        $employee = User::withoutTrashed()->find($id);
        if(!$employee) {
            return response()->json([
                'message'=> 'Not found',
            ]);
        }
        $employee->update($request->all());
        if($request->file('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('Employees', $image , 'Users');
            $employee->image = $path;
            }
        return response()->json([
            'message'=> 'Added successfully',
        ]);

    }
    public function destroy($id)
    {
        $employee = User::withoutTrashed()->find($id);
        if(!$employee) {
            return response()->json([
                'message'=> 'Not found',
                ]);
    }
    $employee->delete();
    return response()->json([
        'message'=> 'Deleted Successfully',
        ]);
    }
    
}
