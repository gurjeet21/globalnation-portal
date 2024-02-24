<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RimController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DownloadController;
//use App\Http\Controllers\CronJobController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\TwoFactorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    if(\Auth::check() == 1 ){
        return redirect()->to(route('login'));
    }
    return view('auth.login');
});

Route::match(['GET','POST'],'/login_2fa', [TwoFactorController::class, 'login_2fa'])->middleware(['auth'])->name('login_2fa');
Route::match(['GET','POST'],'/generate_qr', [TwoFactorController::class, 'generate_qr'])->middleware(['auth'])->name('generate_qr');


//Route::get('/dashboard', [UserController::class, 'dashboard_count'])->middleware(['auth', 'verified','2FA_auth'])->name('dashboard');
Route::get('/dashboard', [UserController::class, 'dashboard_count'])->name('dashboard');


Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('/two-fa', [TwoFactorController::class, 'two_fa'])->name('twoFa');
    Route::post('/complete-registration', [TwoFactorController::class, 'complete_registration'])->name('complete_registration');

    /* route with 2FA */
    //Route::middleware(['2FA_auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        /* user routes*/
        Route::get('/users', [UserController::class, 'index'])->name('user');
        Route::match(['GET','POST'],'/add-user', [UserController::class, 'add_user'])->name('user.add');
        Route::match(['GET','POST'],'/update-my-profile', [UserController::class, 'update_my_profile'])->name('user.profile');
        Route::match(['GET','POST'],'/update-user/{user_id}', [UserController::class, 'update_user'])->name('user.update');
        Route::get('/delete-user/{user_id}', [UserController::class, 'delete_user'])->name('user.delete');

        /* setting routes*/
        Route::get('/settings', [SettingController::class, 'index'])->name('setting');
    //});
});

/* clear-cache */
Route::get('/c', function() {
    \Artisan::call('cache:clear');
    \Artisan::call('optimize:clear');
    \Artisan::call('route:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:cache');
    return '<h1>Cache facade value cleared</h1>';
});

//require __DIR__.'/cron.php';
require __DIR__.'/auth.php';
