<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\UserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\API\UserLoginRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(UserLoginRequest $request)
    {
    $user = User::where('email', $request->email)->first();
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return response()->json([
        'message' => 'User loged in successfully',
        'user' => $user,
        'token'=> $user->createToken('laravel_token')->plainTextToken
    ]);
    }

    public function register(UserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id'=> $request->department_id,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token'=> $user->createToken('laravel_token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => ' logged out Successfully',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
