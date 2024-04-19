<?php

use App\Http\Controllers\ActiveUser;
use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CodeCheckController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RolesController;
use App\Models\User;
use Chatify\Http\Controllers\Api\MessagesController as ApiMessagesController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Authincation
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthLoginController::class,'login'])->middleware(['guest:sanctum']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout',[LogOutController::class,'logout'])->middleware('auth:sanctum');
Route::post('password/email',  ForgotPasswordController::class);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', ResetPasswordController::class);
////////////////////////////////////////////////

// roles

Route::group(['middleware' => ['auth:sanctum','role:Admin|co-Admin']], function () {

    Route::post('user/{id}/block', [ActiveUser::class,'Active']);//اعمل بلوك واشيل البلوك

    Route::get('users', function(){
    return User::withoutRole(['Admin','co-Admin'])->get();//يرجع كل اليوزرس
    });

 });


 Route::group(['middleware' => ['auth:sanctum','role:Admin']], function () {
    Route::get('co-Admins', function(){
        return $users = User::role('co-Admin')->get();//يرجع كل مساعدين الادمن
        });

    Route::post('user/{id}/co-AdminRole',[RolesController::class,'assignRole']);//عشان اعمل مساعد للادمن


 });
 //////////////////////////////////////////////

// chat
Route::group(['middleware' => ['auth:sanctum','AuthCheck']], function () {

Route::post('/sendMessage/{id}', [ApiMessagesController::class,'send'])->name('api.send.message');
// Route::post('/chat/auth', [ApiMessagesController::class,'pusherAuth'])->name('api.pusher.auth')->middleware(['auth:sanctum']);
Route::post('/idInfo', [ApiMessagesController::class,'idFetchData'])->name('api.idInfo');
Route::post('/fetchMessages/{id}',[ApiMessagesController::class,'fetch'])->name('api.fetch.messages');
Route::post('/makeSeen', [ApiMessagesController::class,'seen'])->name('api.messages.seen');
Route::get('/getContacts', [ApiMessagesController::class,'getContacts'])->name('api.contacts.get');
// Route::post('/star/{id}', [ApiMessagesController::class,'favorite'])->name('api.star')->middleware(['auth:sanctum']);
// Route::post('/favorites', [ApiMessagesController::class,'getFavorites'])->name('api.favorites')->middleware(['auth:sanctum']);
Route::get('/search', [ApiMessagesController::class,'search'])->name('api.search');
Route::post('/deleteConversation/{id}', [ApiMessagesController::class,'deleteConversation'])->name('api.conversation.delete');
Route::post('messenger/delete-message/{id}', [ApiMessagesController::class, 'deleteMessage'])->name('messenger.delete-message');
Route::post('/updateSettings', [ApiMessagesController::class, 'updateSettings'])->name('api.avatar.update');

//////////////////////////////////////////////////////////////////////////////////
/// image API/////
    Route::get('students',[StudentController::class,'index']);
    Route::post('add-student',[StudentController::class,'store']);
    Route::get('/students/{id}',[StudentController::class,'show']);
    Route::delete('/students/{id}',[StudentController::class,'destroy']);
    Route::post('/students/{id}',[StudentController::class,'update']);
});
