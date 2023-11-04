<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\DepartmentCreateRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
            $departments = Department::all()-> where('is_active', true);
            return response()->json(['departments' => $departments]);
        
    }

    public function store(DepartmentCreateRequest $request)
    {
        
            $department = Department::create([
                'name'=> $request->name ,
                'company_id' => $request->company_id,
                'is_active' => $request->is_active,
            ]);
            return response()->json([
                'message' => 'created successfully',
                'department' => $department,
            ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
                $department = Department::withoutTrashed()->find($id);
                if($department){
                    return response()->json([
                        'department' => $department,
                    ]);
                }
                return response()->json([
                    'message'=> 'department not found',
                ]);
         
    }

    
    public function update(Request $request ,$id)
    {
        
            $department = Department::withoutTrashed()->find($id);
            if(!$department){
                return response()->json([
                    'message'=> 'Not found',
                ]);
            }
            $department->update($request->all());
            return response()->json([
                'message'=> 'Added successfully',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department = Department::withoutTrashed()->find($id);
        if($department == null){
            return response()->json([
                'message'=> 'Not found',
            ]);
        }
        $department->delete();
        return response()->json([
            'message'=> 'deleted successfully',
        ]);
    }
}
