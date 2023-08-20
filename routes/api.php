<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserEventsController;
use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\EventPhotosController;
use App\Http\Controllers\Api\PhotoCommentsController;
use App\Http\Controllers\Api\EventInvitationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Events
        Route::get('/users/{user}/events', [
            UserEventsController::class,
            'index',
        ])->name('users.events.index');
        Route::post('/users/{user}/events', [
            UserEventsController::class,
            'store',
        ])->name('users.events.store');

        Route::apiResource('events', EventController::class);

        // Event Photos
        Route::get('/events/{event}/photos', [
            EventPhotosController::class,
            'index',
        ])->name('events.photos.index');
        Route::post('/events/{event}/photos', [
            EventPhotosController::class,
            'store',
        ])->name('events.photos.store');

        // Event Invitations
        Route::get('/events/{event}/invitations', [
            EventInvitationsController::class,
            'index',
        ])->name('events.invitations.index');
        Route::post('/events/{event}/invitations', [
            EventInvitationsController::class,
            'store',
        ])->name('events.invitations.store');

        Route::apiResource('photos', PhotoController::class);

        // Photo Comments
        Route::get('/photos/{photo}/comments', [
            PhotoCommentsController::class,
            'index',
        ])->name('photos.comments.index');
        Route::post('/photos/{photo}/comments', [
            PhotoCommentsController::class,
            'store',
        ])->name('photos.comments.store');

        Route::apiResource('invitations', InvitationController::class);

        Route::apiResource('comments', CommentController::class);
    });
