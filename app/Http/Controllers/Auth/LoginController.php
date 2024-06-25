<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Middleware;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ApiResponse::sendResponse(401,'User accound doesnot exist',null);
        }

        $device_name=$request->post('device_name',$request->userAgent());
        $isadmin=$user->getRoleNames();
        $isadmin=$user->hasRole("Admin")||$user->hasRole("co-Admin");

        return ApiResponse::sendResponse(201,'User login successfuly',
            ['token'=>$user->createToken($device_name)->plainTextToken,
                'name'=>$user->name,
                'email'=>$user->email,
                "isadmin"=>$isadmin,]);

    }
}
