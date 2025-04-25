<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CollectionBookController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::apiResource('books', BookController::class);

Route::apiResource('collections', CollectionController::class);

Route::apiResource('collection-book', CollectionBookController::class);

Route::apiResource('memberships', MembershipController::class);

Route::post('/collections/all-by-user-email', [CollectionController::class, 'allByUserEmail']);

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return response()->json(['message' => 'Config cleared successfully.']);
});

Route::get('/generate-link-storage', function () {
    Artisan::call('storage:link');
    return response()->json(['message' => 'Storage link created successfully.']);
});