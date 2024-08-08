<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;


class EmployeeApiController extends Controller
{
    public function create()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'position' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => 'failed']);
        }

        $employee = Employee::create([
            'name' => request()->name,
            'email' => request()->email,
            'position' => request()->position,
            'user_id' => Auth::id()
        ]);

        return response()->json(['employee' => $employee, 201]);
    }

    public function index()
    {
        $employees = Employee::all();
        return response()->json(['employees' => $employees], 200);
    }


    public function destory(Employee $employee)
    {
        $employee = Employee::where('id', $employee->id)->first();
        $employee->delete();

        return response()->json(['data' => 'deleted'], 200);
    }
}
