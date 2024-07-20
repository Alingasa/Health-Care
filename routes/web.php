<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\statusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Login
Route::get('/login', [LoginController::class, 'login'])->name('login');


//HOMECONTROLLER FOR Dashboard and home
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
// Route::get('/home', [HomeController::class, 'home'])->name('home');

//Users
Route::resource('user', UserController::class);

//Role
Route::resource('role', RoleController::class);

//Patient
Route::resource('patient', PatientController::class);

//Doctor
Route::resource('doctor', DoctorController::class);

//Appiointment
Route::resource('appointment', AppointmentController::class);

//Status Updates
Route::resource('status', statusController::class);
