<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

class RolesController extends Controller
{
  public  function assignRole(Request $request,$id){
        $user= User::find($id);
        $user->assignRole('co-Admin');
        return ApiResponse::sendResponse(200,['user'=>$user->email,'Role'=>$user->getRoleNames()],null);
        return $user;

     }
}
