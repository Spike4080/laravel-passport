<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;


class EmployeeApiController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'max:100', 'min:10'],
            'position' => ['required', 'max:255', 'min:3']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $employee = Employee::create([
            'name' => request()->name,
            'email' => request()->email,
            'position' => request()->position,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully',
            'employee' => $employee
        ], 201);
    }


    public function index()
    {
        $employees = Employee::all();
        return response()->json(['employees' => $employees], 200);
    }


    public function destory($id)
    {
        $employee = Employee::where('id', $id)->first();
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found'
            ], 404);
        }
        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully'
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            [
                'name' => ['nullable', 'max:255'],
                'email' => ['nullable', 'email'],
                'position' => ['nullable', 'max:255']
            ]
        ]);

        $employee = Employee::where('id', $id)->first();
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Employee updated successfully',
            'employee' => $employee
        ], 200);
    }
}
