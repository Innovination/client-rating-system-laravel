<?php

use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\DisputeCategoriesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Agency\Auth\RegisterController as AgencyRegisterController;
use App\Http\Controllers\Agency\ClientController as AgencyClientController;
use App\Http\Controllers\Agency\DisputeController;
use App\Http\Controllers\Agency\FeedbackController;
use App\Http\Controllers\Agency\HomeController as AgencyHomeController;
use App\Http\Controllers\Agency\NotificationController as AgencyNotificationController;
use App\Http\Controllers\Agency\ProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ClientDirectoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }

    return view('agency.landing');
})->name('landing');

Route::get('/clients', [ClientDirectoryController::class, 'index'])->middleware('throttle:60,1')->name('clients.index');
Route::get('/clients/{client}', [ClientDirectoryController::class, 'show'])->name('clients.show');

Route::get('/home', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $isAdmin = auth()->user()->is_admin || auth()->user()->user_type === 'admin';
    $targetRoute = $isAdmin ? 'admin.home' : 'agency.home';

    return session('status')
        ? redirect()->route($targetRoute)->with('status', session('status'))
        : redirect()->route($targetRoute);
})->name('home');

Auth::routes([
    'register' => false,
    'verify' => true,
]);

Route::get('/agency/register', [AgencyRegisterController::class, 'showRegistrationForm'])->name('agency.register');
Route::post('/agency/register', [AgencyRegisterController::class, 'register'])->name('agency.register.store');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'active', 'can:admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/maintenance/migrate', [MaintenanceController::class, 'migrate'])->name('maintenance.migrate');
    Route::post('/maintenance/cache-refresh', [MaintenanceController::class, 'cacheRefresh'])->name('maintenance.cacheRefresh');
    Route::post('/maintenance/optimize', [MaintenanceController::class, 'optimize'])->name('maintenance.optimize');

    Route::get('moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::patch('moderation/disputes/{dispute}', [ModerationController::class, 'updateDispute'])->name('moderation.disputes.update');
    Route::delete('moderation/disputes/{dispute}', [ModerationController::class, 'destroyDispute'])->name('moderation.disputes.destroy');
    Route::patch('moderation/feedback/{feedback}', [ModerationController::class, 'updateFeedback'])->name('moderation.feedback.update');
    Route::delete('moderation/feedback/{feedback}', [ModerationController::class, 'destroyFeedback'])->name('moderation.feedback.destroy');

    Route::resource('dispute-categories', DisputeCategoriesController::class)->except(['show']);

    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::post('users/{user}/suspend', [UsersController::class, 'suspend'])->name('users.suspend');
    Route::post('users/{user}/unsuspend', [UsersController::class, 'unsuspend'])->name('users.unsuspend');
    Route::resource('users', UsersController::class);
    Route::post('users/approve-verification', [UsersController::class, 'approveVerification'])->name('users.approveVerification');

    Route::resource('audit-logs', AuditLogsController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    Route::delete('settings/destroy', [SettingsController::class, 'massDestroy'])->name('settings.massDestroy');
    Route::post('settings/parse-csv-import', [SettingsController::class, 'parseCsvImport'])->name('settings.parseCsvImport');
    Route::post('settings/process-csv-import', [SettingsController::class, 'processCsvImport'])->name('settings.processCsvImport');
    Route::resource('settings', SettingsController::class);

    Route::delete('cities/destroy', [CityController::class, 'massDestroy'])->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', [CityController::class, 'parseCsvImport'])->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', [CityController::class, 'processCsvImport'])->name('cities.processCsvImport');
    Route::resource('cities', CityController::class);

    Route::delete('states/destroy', [StateController::class, 'massDestroy'])->name('states.massDestroy');
    Route::post('states/parse-csv-import', [StateController::class, 'parseCsvImport'])->name('states.parseCsvImport');
    Route::post('states/process-csv-import', [StateController::class, 'processCsvImport'])->name('states.processCsvImport');
    Route::resource('states', StateController::class);

    Route::delete('countries/destroy', [CountriesController::class, 'massDestroy'])->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', [CountriesController::class, 'parseCsvImport'])->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', [CountriesController::class, 'processCsvImport'])->name('countries.processCsvImport');
    Route::resource('countries', CountriesController::class);
});

Route::prefix('profile')->name('profile.')->middleware(['auth', 'active'])->group(function () {
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
    }
});

Route::prefix('agency')->name('agency.')->middleware(['auth', 'active'])->group(function () {
    Route::get('/', [AgencyHomeController::class, 'index'])->name('home');
    Route::get('notifications', [AgencyNotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/mark-all-as-read', [AgencyNotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('clients', [AgencyClientController::class, 'index'])->middleware('throttle:60,1')->name('clients.index');
    Route::get('clients/create', [AgencyClientController::class, 'create'])->name('clients.create');
    Route::get('clients/{client}', [AgencyClientController::class, 'show'])->name('clients.show');
    Route::post('clients', [AgencyClientController::class, 'store'])->middleware('throttle:30,1')->name('clients.store');

    Route::middleware(['verified', 'throttle:20,1'])->group(function () {
        Route::post('disputes', [DisputeController::class, 'store'])->name('disputes.store');
        Route::post('feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    });
});
