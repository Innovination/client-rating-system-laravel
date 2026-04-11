<?php

use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DisputeCategoriesController;
use App\Http\Controllers\Agency\Auth\RegisterController as AgencyRegisterController;
use App\Http\Controllers\Agency\ClientController as AgencyClientController;
use App\Http\Controllers\Agency\DisputeController as AgencyDisputeController;
use App\Http\Controllers\Agency\FeedbackController as AgencyFeedbackController;
use App\Http\Controllers\Agency\HomeController as AgencyHomeController;
use App\Http\Controllers\Agency\NotificationController as AgencyNotificationController;
use App\Http\Controllers\Agency\ProfileController as AgencyProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\PublicClientController;
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
Route::get('/clients', [PublicClientController::class, 'index'])->name('clients.index');
Route::get('/clients/{client}', [PublicClientController::class, 'show'])->name('clients.show');

// 🔹 Maintenance Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
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
    Route::post('users/{user}/suspend', [UsersController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/unsuspend', [UsersController::class, 'unsuspend'])->name('users.unsuspend');

    Route::get('moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::post('moderation/disputes/{dispute}/hide', [ModerationController::class, 'hideDispute'])->name('moderation.disputes.hide');
    Route::post('moderation/disputes/{dispute}/restore', [ModerationController::class, 'restoreDispute'])->name('moderation.disputes.restore');
    Route::delete('moderation/disputes/{dispute}', [ModerationController::class, 'deleteDispute'])->name('moderation.disputes.delete');
    Route::post('moderation/feedback/{feedback}/hide', [ModerationController::class, 'hideFeedback'])->name('moderation.feedback.hide');
    Route::post('moderation/feedback/{feedback}/restore', [ModerationController::class, 'restoreFeedback'])->name('moderation.feedback.restore');
    Route::delete('moderation/feedback/{feedback}', [ModerationController::class, 'deleteFeedback'])->name('moderation.feedback.delete');

    Route::get('dispute-categories', [DisputeCategoriesController::class, 'index'])->name('dispute-categories.index');
    Route::post('dispute-categories', [DisputeCategoriesController::class, 'store'])->name('dispute-categories.store');
    Route::put('dispute-categories/{category}', [DisputeCategoriesController::class, 'update'])->name('dispute-categories.update');
    Route::delete('dispute-categories/{category}', [DisputeCategoriesController::class, 'destroy'])->name('dispute-categories.destroy');

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

Route::prefix('agency')->name('agency.')->middleware(['auth', 'agency'])->group(function () {
    Route::get('/', [AgencyHomeController::class, 'index'])->name('home');
    Route::get('profile', [AgencyProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AgencyProfileController::class, 'update'])->name('profile.update');
    Route::get('clients', [AgencyClientController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [AgencyClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [AgencyClientController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}', [AgencyClientController::class, 'show'])->name('clients.show');
    Route::post('disputes', [AgencyDisputeController::class, 'store'])->name('disputes.store');
    Route::post('feedback', [AgencyFeedbackController::class, 'store'])->name('feedback.store');
    Route::get('notifications', [AgencyNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [AgencyNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
