<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Notification API Routes (for AJAX polling and real-time updates)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('notifications')->name('api.notifications.')->group(function () {
        Route::get('/unread', [NotificationController::class, 'getUnread'])->name('unread');
        Route::get('/count', [NotificationController::class, 'getUnreadCount'])->name('count');
        Route::get('/check-new', [NotificationController::class, 'checkNew'])->name('check-new');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
    });
});

// Alternative: Routes without Sanctum (using web middleware)
Route::middleware(['web', 'auth'])->prefix('api')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread']);
    Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount']);
    Route::get('/notifications/check-new', [NotificationController::class, 'checkNew']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});
