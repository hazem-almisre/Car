<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = auth()->user();
            $success['token'] = $user->createToken($request->password . $request->email)->accessToken;
            $success['id'] = $user->id;
            return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'user'], 200);
        }
        return response()->json(['massage' => 'the password or email are not true']);
    }
}
