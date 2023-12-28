<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthManageController;
use App\Http\Controllers\Api\CategoryManageController;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthManageController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    /**
     * Category
    */

    Route::get('/category/list', [CategoryManageController::class, 'list']);
    Route::get('/category/individual/list/{category_id}', [CategoryManageController::class, 'individual_list']);
    Route::post('/category/add', [CategoryManageController::class, 'add']);
    Route::post('/category/edit', [CategoryManageController::class, 'edit']);
    Route::get('/category/delete/{category_id}', [CategoryManageController::class, 'delete']);

    /**
     * Task
    */

    Route::get('/task/list', [TaskController::class, 'list']);
    Route::post('/task/add', [TaskController::class, 'add']);
    Route::post('/task/edit', [TaskController::class, 'edit']);
    Route::get('/task/delete/{task_id}', [TaskController::class, 'delete']);

});
