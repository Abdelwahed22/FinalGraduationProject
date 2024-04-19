<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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




});

require __DIR__.'/auth.php';
 Route::get('role', function () {
     $user=Auth::user();
     $user->assignRole('Admin');

 })->middleware('auth');


