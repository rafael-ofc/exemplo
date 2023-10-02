<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\LostController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

Route::get('/ping', [RouteController::class, 'ping']);
Route::any('/401', [RouteController::class, 'unauthorized'])->name('login');

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/check', [AuthController::class, 'check']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/walls', [WallController::class, 'read']);
    Route::get('/wall/{id}/like', [WallController::class, 'like']);

    Route::get('/docs', [DocController::class, 'read']);

    Route::get('/billets', [BilletController::class, 'read']);

    Route::get('/warnings', [WarningController::class, 'read']);
    Route::post('/warning', [WarningController::class, 'create']);

    Route::get('/losts', [LostController::class, 'read']);
    Route::post('/lost', [LostController::class, 'create']);
    Route::put('/lost/{id}', [LostController::class, 'update']);

    Route::get('/unit/{id}', [UnitController::class, 'read']);

    Route::post('/people', [UnitController::class, 'setPeople']);
    Route::delete('/people/{id}', [UnitController::class, 'deletePeople']);

    Route::post('/vehicle', [UnitController::class, 'setVehicle']);
    Route::delete('/vehicle/{id}', [UnitController::class, 'deleteVehicle']);

    Route::post('/pet', [UnitController::class, 'setPet']);
    Route::delete('/pet/{id}', [UnitController::class, 'deletePet']);

    Route::get('/reservations', [ReservationController::class, 'read']);
    Route::get('/reservation/{id}/disabled', [ReservationController::class, 'getDisabled']);
    Route::post('/reservation', [ReservationController::class, 'create']);
    Route::delete('/reservation/{id}', [ReservationController::class, 'delete']);

    Route::get('/user', [UserController::class, 'read']);
    Route::get('/user/reservation', [UserController::class, 'getReservation']);
    Route::put('/user', [UserController::class, 'update']);
});
