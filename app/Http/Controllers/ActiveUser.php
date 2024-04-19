<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActiveUser extends Controller
{
    public function Active(Request $request,$id) {

       $user=User::withoutRole(['Admin'])->find($id);
if($user){
if($user->id!=$request->user()->id){


        if($user->Active=="Active"){
            $user->Active="Un-Active";
            $user->save();

          return ApiResponse::sendResponse(201,'User blocked',null);
        }
        else{
            $user->Active="Active";
            $user->save();

            return ApiResponse::sendResponse(201,'User unblocked',null);
        }

    }else{
        return ApiResponse::sendResponse(404,'un Authnicated',null);
}



}else{
    return ApiResponse::sendResponse(404,'un Authnicated',null);
}
    }
}
