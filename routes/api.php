<?php

use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CompleteTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::apiResource('/products',ProductController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/debug', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'headers' => $request->headers->all(),
    ]);
});
