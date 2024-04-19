<?php
namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\ResetCodePassword;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Change the password (Setp 3)
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $passwordReset = ResetCodePassword::Where('code', $request->code)->first();

        if ($passwordReset->isExpire()) {
            // return $this->jsonResponse(null, trans('passwords.code_is_expire'), 422);
            return ApiResponse::sendResponse(422,trans('passwords.code_is_expire'),null);
        }

        $user = User::Where('email', $passwordReset->email)->first();
        $user->password=Hash::make($request->password);
        $user->save();

        // $user->update($request->only('password'));

        $passwordReset->delete();

        // return $this->jsonResponse(null, trans('site.password_has_been_successfully_reset'), 200);
        return ApiResponse::sendResponse(200,trans('site.password_has_been_successfully_reset'),null);
    }
}
