<?php

use Illuminate\Support\Facades\Route;

// Auth & Admin controllers
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\FinancialYearMappingController;

// Masters controllers
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\WorkStatusController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\BloodGroupController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ModuleController;

/*
|--------------------------------------------------------------------------
| Public (guest) routes
|--------------------------------------------------------------------------
| These routes are accessible without authentication.
| Used for login, forgot MPIN, OTP, etc.
*/

// Login page
Route::view('/', 'auth.login')->name('login');

// Forgot MPIN page
Route::view('/forgot-mpin', 'auth.forgot-mpin')->name('forgot.mpin');

// Set MPIN page
Route::view('/set-mpin', 'auth.set-mpin')->name('set.mpin');

// OTP page
Route::view('/otp', 'auth.otp')->name('otp');

/*
|--------------------------------------------------------------------------
| Auth-related POST actions
|--------------------------------------------------------------------------
*/

// Login with mobile + MPIN
Route::post('/login', [SignInController::class, 'login'])
    ->name('login.submit');

// Forgot MPIN → send OTP
Route::post('/send-otp', [SignInController::class, 'sendOtp'])
    ->name('forgot.mpin.submit');

// Resend OTP
Route::post('/resend-otp', [SignInController::class, 'resendOtp'])
    ->name('otp.resend');

// Verify OTP
Route::post('/verify-otp', [SignInController::class, 'verifyOtp'])
    ->name('otp.verify');

// Set new MPIN after OTP
Route::post('/set-mpin', [SignInController::class, 'setMpin'])
    ->name('mpin.store');

/*
|--------------------------------------------------------------------------
| Authenticated + Admin-only routes
|--------------------------------------------------------------------------
| These routes require:
|  - user must be logged in  (auth middleware)
|  - user must be admin      (admin middleware)
|
| Make sure in bootstrap/app.php you have:
|
| ->withMiddleware(function (Middleware $middleware) {
|     $middleware->alias([
|         'admin' => \App\Http\Middleware\AdminMiddleware::class,
|     ]);
| })
|
*/

Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin prefix & name prefix
    |--------------------------------------------------------------------------
    | All URLs will start with /admin
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        /*
        |----------------------------------------------------------------------
        | Dashboard
        |----------------------------------------------------------------------
        */
        Route::view('dashboard', 'admin.dashboard.index')
            ->name('dashboard');

        /*
        |----------------------------------------------------------------------
        | Role & User Management
        |----------------------------------------------------------------------
        */

        // Roles (except show)
        Route::resource('roles', RoleController::class)->except(['show']);

        // Extra Role routes (soft delete, restore, force delete)
        Route::get('roles/deleted', [RoleController::class, 'DisplayDeletedRoles'])
            ->name('roles.deleted');
        Route::put('roles/restore/{id}', [RoleController::class, 'restore'])
            ->name('roles.restore');
        Route::delete('roles/force-delete/{id}', [RoleController::class, 'forceDeleteRole'])
            ->name('roles.forceDelete');

        // Users (except show)
        Route::resource('users', UserController::class)->except(['show']);

        // Extra User routes (soft delete, restore, force delete)
        Route::get('users/deleted', [UserController::class, 'displayDeletedUser'])
            ->name('users.deleted');
        Route::put('users/restore/{id}', [UserController::class, 'restore'])
            ->name('users.restore');
        Route::delete('users/force-delete/{id}', [UserController::class, 'forceDeleteUser'])
            ->name('users.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Financial Years & Mapping
        |----------------------------------------------------------------------
        */

        // Financial years
        Route::get('financial-years', [FinancialYearController::class, 'index'])
            ->name('financial-years.index');
        Route::get('financial-years/create', [FinancialYearController::class, 'create'])
            ->name('financial-years.create');
        Route::post('financial-years', [FinancialYearController::class, 'store'])
            ->name('financial-years.store');

        // Financial year mapping
        Route::get('financial-years/mapping', [FinancialYearMappingController::class, 'index'])
            ->name('financial-years.mapping');
        Route::post('financial-years/mapping', [FinancialYearMappingController::class, 'store'])
            ->name('financial-years.mapping.store');

        /*
        |----------------------------------------------------------------------
        | Religion Master
        |----------------------------------------------------------------------
        */

        Route::prefix('religion')->name('religion.')->group(function () {
            Route::get('/', [ReligionController::class, 'index'])->name('index');
            Route::get('/create', [ReligionController::class, 'create'])->name('create');
            Route::post('/store', [ReligionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ReligionController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ReligionController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ReligionController::class, 'destroy'])->name('delete');

            Route::get('/trash', [ReligionController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [ReligionController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [ReligionController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Job Type Master
        |----------------------------------------------------------------------
        */

        Route::prefix('job-type')->name('job-type.')->group(function () {
            Route::get('/', [JobTypeController::class, 'index'])->name('index');
            Route::get('/create', [JobTypeController::class, 'create'])->name('create');
            Route::post('/store', [JobTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [JobTypeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [JobTypeController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [JobTypeController::class, 'destroy'])->name('delete');

            Route::get('/trash', [JobTypeController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [JobTypeController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [JobTypeController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Work Status Master
        |----------------------------------------------------------------------
        */

        Route::prefix('work-status')->name('work-status.')->group(function () {
            Route::get('/', [WorkStatusController::class, 'index'])->name('index');
            Route::get('/create', [WorkStatusController::class, 'create'])->name('create');
            Route::post('/store', [WorkStatusController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WorkStatusController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [WorkStatusController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [WorkStatusController::class, 'destroy'])->name('delete');

            Route::get('/trash', [WorkStatusController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [WorkStatusController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [WorkStatusController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Blood Group Master
        |----------------------------------------------------------------------
        */

        Route::prefix('masters')->group(function () {
            Route::resource('blood-groups', BloodGroupController::class)->except(['show']);
        });

        Route::get('blood-groups/deleted/history', [BloodGroupController::class, 'deletedHistory'])
            ->name('blood-groups.deleted');
        Route::put('blood-groups/{id}/restore', [BloodGroupController::class, 'restore'])
            ->name('blood-groups.restore');
        Route::delete('blood-groups/{id}/force-delete', [BloodGroupController::class, 'forceDelete'])
            ->name('blood-groups.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Designation Master
        |----------------------------------------------------------------------
        */

        Route::prefix('designation')->name('designation.')->group(function () {
            Route::get('/', [DesignationController::class, 'index'])->name('index');
            Route::get('/create', [DesignationController::class, 'create'])->name('create');
            Route::post('/store', [DesignationController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [DesignationController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [DesignationController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [DesignationController::class, 'destroy'])->name('delete');

            Route::get('/trash', [DesignationController::class, 'trash'])->name('trash');
            Route::get('/restore/{id}', [DesignationController::class, 'restore'])->name('restore');
            Route::get('/force-delete/{id}', [DesignationController::class, 'forceDelete'])->name('forceDelete');
        });

        /*
        |----------------------------------------------------------------------
        | Department Master
        |----------------------------------------------------------------------
        */

        Route::resource('departments', DepartmentController::class);
        Route::get('departments/deleted/history', [DepartmentController::class, 'deletedHistory'])
            ->name('departments.deleted');
        Route::put('departments/{id}/restore', [DepartmentController::class, 'restore'])
            ->name('departments.restore');
        Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete'])
            ->name('departments.forceDelete');

        /*
        |----------------------------------------------------------------------
        | Organization, Institutions, Modules
        |----------------------------------------------------------------------
        */

        Route::resource('organization', OrganizationController::class);
        Route::resource('institutions', InstitutionController::class);
        Route::resource('modules', ModuleController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Logout (authenticated users)
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [SignInController::class, 'logout'])->name('logout');
});
