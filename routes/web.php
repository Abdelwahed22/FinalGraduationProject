<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /////  Image Routes /////////////

    Route::get('students',[StudentController::class,'index']);
    Route::get('add-student',[StudentController::class,'create']);
    Route::post('add-student',[StudentController::class,'store']);
    Route::get('edit-student/{id}',[StudentController::class,'edit']);
    Route::put('update-student/{id}',[StudentController::class,'update']);
    Route::get('delete-student/{id}',[StudentController::class,'destroy']);


    //////// QR ///////


    Route::get('create-qrcode',[QrController::class,'index']);
    Route::post('qrcode',[QrController::class,'create'])->name('qr');




});

require __DIR__.'/auth.php';
 Route::get('role', function () {
     $user=Auth::user();
     $user->assignRole('Admin');

 })->middleware('auth');

 Route::get("create_admin_role",function (){
      $role =Role::create(['name' => 'Admin']);
      return \App\Helpers\ApiResponse::sendResponse(201,"admin created successfully".Auth::user()->name);
 })->middleware('auth');

Route::get("create_co_admin_role",function (){
    return $role =Role::create(['name' => 'co-Admin']);

})->middleware('auth');

Route::get("assign_admin_role",function (){
    $user=Auth::user();
    $user->assignRole('Admin');
});

Route::get("assign_co_admin_role",function (){
    $user=Auth::user();

    $user->assignRole('co_Admin');
});
