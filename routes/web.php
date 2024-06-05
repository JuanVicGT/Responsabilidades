<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Redirect;

// Dashboard
Route::get('/', function () {
    return Redirect::to('/dashboard');
})->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(ProfileController::class)->prefix('/Profile')->name('profile.')
        ->group(function () {
            // Views
            Route::get('/', 'edit')->name('edit');

            // Actions
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'destroy')->name('destroy');
        });

    Route::controller(Backend\PermissionController::class)->prefix('/Permission')->name('permission.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\RoleController::class)->prefix('/Role')->name('role.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\UserController::class)->prefix('/User')->name('user.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\AttendanceController::class)->prefix('/Attendance')->name('attendance.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\DependencyController::class)->prefix('/Dependency')->name('dependency.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\EventController::class)->prefix('/Event')->name('event.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\ItemController::class)->prefix('/Item')->name('item.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\TodoController::class)->prefix('/Todo')->name('todo.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');
        });

    Route::controller(Backend\ResponsabilitySheetController::class)->prefix('/Responsability')->name('responsibility-sheet.')
        ->group(function () {
            // Views
            Route::get('/', 'index')->name('index');
            Route::get('/Create', 'create')->name('create');
            Route::get('/Edit/{id}', 'edit')->name('edit');
            Route::get('/Show/{id}', 'show')->name('show');

            // Actions
            Route::post('/Store', 'store')->name('store');
            Route::patch('/Update', 'update')->name('update');
            Route::delete('/Delete', 'delete')->name('destroy');

            // Actios to lines
            Route::post('/StoreLine', 'store')->name('line.store');
            Route::patch('/UpdateLine', 'update')->name('line.update');
            Route::delete('/DeleteLine', 'delete')->name('line.delete');

            // Actios to observations
            Route::post('/StoreOb', 'store')->name('ob.store');
            Route::patch('/UpdateOb', 'update')->name('ob.update');
            Route::delete('/DeleteOb', 'delete')->name('ob.delete');
        });
});

require __DIR__ . '/auth.php';
