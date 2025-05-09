<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Department;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/employees', function (Request $request) {
    $employee = new Employee();
    $employee->name = $request->input('name');
    $employee->email = $request->input('email');
    $employee->position = $request->input('position');
    $department_id = $request->input('department_id');
    $department= Department::find($department_id );
    $employee->department()->associate($department);
    $employee->save();
    return response()->json($employee);
});

Route::get('/employees', function(Request $request){
    $employees = Employee::all();
    return response()->json($employees);
});

Route::get('/employees/{id}', function($id){
    $employee = Employee::find($id);
    return response()->json($employee);
});

Route::patch('/employees/{id}', function(Request $request, $id){
    $employee = Employee::find($id);

    if ($request->input('name') !== null){
        $employee->name = $request->input('name');
    }

    if ($request->input('email')!== null){
        $employee->email = $request->input('email');
    }

    if ($request->input('position')!== null){
        $employee->position = $request->input('position');
    }

    if ($request->input('department_id')!== null){
        $employee->department_id = $request->input('department_id');
    }

    $employee->save();
    return response()->json($employee);
});

Route::delete('/employees/{id}', function($id){
    $employee = Employee::find($id);

    $employee->delete();

    return response()->json($employee);
});

Route::post('/departments', function(Request $request){
    $department = new Department();
    $department->name = $request->input('name');
    $department->description = $request->input('description');
    $department->save();
    return response()->json($department);
});

Route::get('/departments', function(Request $request){
    $departments = Department::all();
    return response()->json($departments);
});

Route::get('/departments/{id}', function($id){
    $department = Department::find($id);
    return response()->json($department);
});

Route::patch('/departments/{id}', function(Request $request, $id){
    $department = Department::find($id);

    if ($request->input('name')!== null){
        $department->name = $request->input('name');
    }

    if ($request->input('description')!== null){
        $department->description = $request->input('description');
    }

    $department->save();
    return response()->json($department);
});

Route::delete('/departments/{id}', function($id){
    $department = Department::find($id);

    $department->delete();

    return response()->json($department);
});

Route::get('/employee/department', function(){
    $employees = Employee::with('department')->get();
    return response()->json($employees);
});

Route::get('/department/employee', function(){
    $departments = Department::with('employees')->get();
    return response()->json($departments);
});

Route::get('/employee/department/{id}', function($id){
    $employee = Employee::find($id);
    $department = $employee->department;
    return response()->json($department);
});

Route::get('/department/employee/{id}', function($id){
    $department = Department::find($id);
    $employees = $department->employees;
    return response()->json($employees);
});