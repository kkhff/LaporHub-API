<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/delete',[AuthController::class, 'destroy']);

    Route::get('/categories', function() {
        return response()->json([
            'success' => true,
            'data' => \App\Models\Category::all()
        ]);
    });

    Route::get('/myReports', [ReportController::class, 'myReports']);
    Route::apiResource('reports', ReportController::class);
});

Route::middleware(['auth:sanctum', 'role:admin,petugas'])->group(function () {
    Route::patch('/reports/{id}/status', [ReportController::class, 'updateStatus']);
    Route::get('/admin/stats', [AdminController::class, 'index'])->middleware('role:admin');
    Route::get('/admin/users', [AdminController::class, 'showUser'])->middleware('role:admin');
    Route::patch('/admin/{id}/role', [AdminController::class, 'updateRole'])->middleware('role:admin');
});


