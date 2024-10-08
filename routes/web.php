<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\TeamsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');



Route::match(['POST', 'DELETE'], '/bulk-delete/{record?}', function ($record = null) {
    // Convert the record to plural (Crest Apps code generator creates plural controller name eg SchoolsController) and capitalize
    $plural = Str::plural($record);
    $className = ucfirst($plural) . 'Controller'; // Append 'Controller' to the class name

    // Construct the full class name with namespace
    $fullClassName = 'App\\Http\\Controllers\\' . $className;

    // Check if the class exists and instantiate
    if (class_exists($fullClassName)) {
        return app($fullClassName)->bulkDelete(request());
    }

    // Handle invalid class name case
    return redirect()->back()->with('error', 'Invalid record type specified');
})->name('bulkDelete');


Route::group([
    'prefix' => 'roles',
], function () {
    Route::get('/', [RolesController::class, 'index'])
         ->name('roles.role.index');
    Route::get('/create', [RolesController::class, 'create'])
         ->name('roles.role.create');
    Route::get('/show/{role}',[RolesController::class, 'show'])
         ->name('roles.role.show');
    Route::get('/{role}/edit',[RolesController::class, 'edit'])
         ->name('roles.role.edit');
    Route::post('/', [RolesController::class, 'store'])
         ->name('roles.role.store');
    Route::put('role/{role}', [RolesController::class, 'update'])
         ->name('roles.role.update');
    Route::delete('/role/{role}',[RolesController::class, 'destroy'])
         ->name('roles.role.destroy');

});

Route::group([
    'prefix' => 'permissions',
], function () {
    Route::get('/', [PermissionsController::class, 'index'])
         ->name('permissions.permission.index');
    Route::get('/create', [PermissionsController::class, 'create'])
         ->name('permissions.permission.create');
    Route::get('/show/{permission}',[PermissionsController::class, 'show'])
         ->name('permissions.permission.show');
    Route::get('/{permission}/edit',[PermissionsController::class, 'edit'])
         ->name('permissions.permission.edit');
    Route::post('/', [PermissionsController::class, 'store'])
         ->name('permissions.permission.store');
    Route::put('permission/{permission}', [PermissionsController::class, 'update'])
         ->name('permissions.permission.update');
    Route::delete('/permission/{permission}',[PermissionsController::class, 'destroy'])
         ->name('permissions.permission.destroy');

});

Route::group([
    'prefix' => 'teams',
], function () {
    Route::get('/', [TeamsController::class, 'index'])
         ->name('teams.team.index');
    Route::get('/create', [TeamsController::class, 'create'])
         ->name('teams.team.create');
    Route::get('/show/{team}',[TeamsController::class, 'show'])
         ->name('teams.team.show')->where('id', '[0-9]+');
    Route::get('/{team}/edit',[TeamsController::class, 'edit'])
         ->name('teams.team.edit')->where('id', '[0-9]+');
    Route::post('/', [TeamsController::class, 'store'])
         ->name('teams.team.store');
    Route::put('team/{team}', [TeamsController::class, 'update'])
         ->name('teams.team.update')->where('id', '[0-9]+');
    Route::delete('/team/{team}',[TeamsController::class, 'destroy'])
         ->name('teams.team.destroy')->where('id', '[0-9]+');

});
