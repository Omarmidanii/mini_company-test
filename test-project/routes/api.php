<?php

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;


Route::controller(AuthController::class)->group(function () {
  Route::post('register', 'register');
  Route::post('login', 'login');
  Route::post('logout', 'logout')->middleware('auth:sanctum');
  Route::post('refresh', 'refresh')->middleware('auth:sanctum');
});

Route::controller(DepartmentController::class)->middleware('auth:sanctum')->group(function () {
  Route::get('department/index', 'index');
  Route::post('department/store', 'store');
  Route::get('department/show/{id}', 'show');
  Route::put('department/update/{id}', 'update');
  Route::delete('department/delete/{id}', 'destroy');
});

Route::controller(EmployeeController::class)->middleware('auth:sanctum')->group(function () {
  Route::get('Employee/show/{department_id}', 'show');
  Route::get('Employee/showone/{id}', 'index');
  Route::post('Employee/create', 'store');
  Route::post('Employee/edit/{id}', 'update');
  Route::delete('Employee/delete/{id}', 'destroy');
  Route::post('Employee/img' , 'img');
});