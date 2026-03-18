<?php

use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Agency\Auth\RegisterController as AgencyRegisterController;
use App\Http\Controllers\Agency\HomeController as AgencyHomeController;
use App\Http\Controllers\Agency\NotificationController as AgencyNotificationController;
use App\Http\Controllers\Auth\ChangePasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 🔹 Public Landing
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }

    return view('agency.landing');
})->name('landing');

// 🔹 Redirect Home
Route::get('/home', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $isAdmin = auth()->user()->is_admin || auth()->user()->user_type === 'admin';
    $targetRoute = $isAdmin ? 'admin.home' : 'agency.home';

    return session('status')
        ? redirect()->route($targetRoute)->with('status', session('status'))
        : redirect()->route($targetRoute);
});

// 🔹 Authentication Routes
Auth::routes(['register' => false]);

Route::get('/agency/register', [AgencyRegisterController::class, 'showRegistrationForm'])->name('agency.register');
Route::post('/agency/register', [AgencyRegisterController::class, 'register'])->name('agency.register.store');

// 🔹 Maintenance Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Route::get('/run-migrate', [MaintainanceController::class, 'runMigrate'])->name('run.migrate');
    // Route::get('/cache-clear', [MaintainanceController::class, 'cacheClear'])->name('cache.clear');
    // Route::get('/composer-install', [MaintainanceController::class, 'composerInstall'])->name('composer.install');
});

// 🔹 Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/maintenance/migrate', [MaintenanceController::class, 'migrate'])->name('maintenance.migrate');
    Route::post('/maintenance/cache-refresh', [MaintenanceController::class, 'cacheRefresh'])->name('maintenance.cacheRefresh');
    Route::post('/maintenance/optimize', [MaintenanceController::class, 'optimize'])->name('maintenance.optimize');

    //  Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    //  Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    //  Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);
    Route::post('users/approve-verification', [UsersController::class, 'approveVerification'])->name('users.approveVerification');

    //  Audit Logs (Read-Only)
    Route::resource('audit-logs', AuditLogsController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    //  Settings
    Route::delete('settings/destroy', [SettingsController::class, 'massDestroy'])->name('settings.massDestroy');
    Route::post('settings/parse-csv-import', [SettingsController::class, 'parseCsvImport'])->name('settings.parseCsvImport');
    Route::post('settings/process-csv-import', [SettingsController::class, 'processCsvImport'])->name('settings.processCsvImport');
    Route::resource('settings', SettingsController::class);

    //  City
    Route::delete('cities/destroy', [CityController::class, 'massDestroy'])
        ->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', [CityController::class, 'parseCsvImport'])
        ->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', [CityController::class, 'processCsvImport'])
        ->name('cities.processCsvImport');
    Route::resource('cities', CityController::class);

    //  State
    Route::delete('states/destroy', [StateController::class, 'massDestroy'])
        ->name('states.massDestroy');
    Route::post('states/parse-csv-import', [StateController::class, 'parseCsvImport'])
        ->name('states.parseCsvImport');
    Route::post('states/process-csv-import', [StateController::class, 'processCsvImport'])
        ->name('states.processCsvImport');
    Route::resource('states', StateController::class);

    //  Countries
    Route::delete('countries/destroy', [CountriesController::class, 'massDestroy'])
        ->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', [CountriesController::class, 'parseCsvImport'])
        ->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', [CountriesController::class, 'processCsvImport'])
        ->name('countries.processCsvImport');
    Route::resource('countries', CountriesController::class);

});

// 🔹 Profile Routes (Password Reset & Profile Update)
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
    }
});

Route::prefix('agency')->name('agency.')->middleware('auth')->group(function () {
    Route::get('/', [AgencyHomeController::class, 'index'])->name('home');
    Route::get('notifications', [AgencyNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [AgencyNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
