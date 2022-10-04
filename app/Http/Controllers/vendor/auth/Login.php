<?php

namespace App\Http\Controllers\vendor\auth;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    public function login(Request $request)
    {
        if($request->email)
        $vendor = Vendor::query()->where('email', $request->email)->first();

        if ($vendor && Hash::check($request->password, $vendor->password)) {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $success['token'] = $vendor->createToken($request->password . $request->email)->accessToken;
            $success['id'] = $vendor->id;
            return response()->json(["data"=>$success,  'massage' => 'successful','client'=>'vendor'], 200);
        }

        return response()->json(['massage' => 'the password or email are not true']);
    }
}
