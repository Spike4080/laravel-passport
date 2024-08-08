<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'max:255', 'min:4'],
            'email' => ['required', 'email', 'max:100', 'min:10'],
            'password' => ['required', 'min:4', 'max:100']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => 'failed']);
        }

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password)
        ]);

        $token = $user->createToken('passportApi')->accessToken;
        return response()->json(['token' => $token, 200]);
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => 'failed']);
        }

        $cre = ['email' => request()->email, 'password' => request()->password];

        if (auth()->attempt($cre)) {
            $user = auth()->user();
            $token = $user->createToken('passportApi')->accessToken;
            return response()->json(['token' => $token, 200]);
        }
        return response()->json(['error' => 'Unauthorized', 401]);
    }
}
