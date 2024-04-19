<?php
namespace App\Http\Controllers;
use App\Helpers\ApiResponse;
use App\Http\Requests\Auth\CodeCheckRequest;
use App\Models\ResetCodePassword;

class CodeCheckController extends Controller
{
    /**
     * @param  mixed $request
     * @return void
     */
    public function __invoke(CodeCheckRequest $request)
    {
        $passwordReset = ResetCodePassword::Where('code', $request->code)->first();

        if ($passwordReset->isExpire()) {
            // return $this->jsonResponse(null, trans('passwords.code_is_expire'), 422);
            return ApiResponse::sendResponse(422,trans('passwords.code_is_expire'),null);
        }

        // return $this->jsonResponse(['code' => $passwordReset->code], trans('passwords.code_is_valid'), 200);
        return ApiResponse::sendResponse(200,['code' => $passwordReset->code], trans('passwords.code_is_valid'));
    }
}
