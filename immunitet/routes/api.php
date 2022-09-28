<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers as Controller;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [Controller\AuthController::class, 'login']);
    Route::post('/register', [Controller\AuthController::class, 'register']);
    Route::post('/remind-password', [Controller\AuthController::class, 'remindPassword']);
    Route::post('/change-password', [Controller\AuthController::class, 'changePassword']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', [Controller\AuthController::class, 'user']);
     Route::name('company.')->prefix('company')->group(function() {
         Route::get('get', [Controller\CompanyController::class, 'getByUser'])->name('getByUser');
         Route::post('create', [Controller\CompanyController::class, 'createOrUpdateByUser'])->name('createOrUpdateByUser');
         Route::post('update', [Controller\CompanyController::class, 'createOrUpdateByUser'])->name('createOrUpdateByUser');
         Route::post('delete', [Controller\CompanyController::class, 'updateByUser'])->name('deleteByUser');
     });
     Route::name('payment.')->prefix('payment')->group(function() {
         Route::post('cryptogram_payment', [Controller\PaymentController::class, 'create'])->name('cryptogramPayment');
     });
     Route::name('site-requisites.')->prefix('site-requisites')->group(function() {
         Route::get('get', [Controller\SiteVerificationController::class, 'get'])->name('get');
         Route::post('create', [Controller\SiteVerificationController::class, 'createOrUpdate'])->name('create');
         Route::get('getPeriodList', [Controller\SiteVerificationController::class, 'getPeriodList'])->name('getPeriodList');
     });
     Route::name('email-notification.')->prefix('email-notification')->group(function() {
         Route::get('get', [Controller\EmailNotificationController::class, 'get'])->name('get');
         Route::post('create', [Controller\EmailNotificationController::class, 'createOrUpdate'])->name('create');
         Route::get('getPeriodList', [Controller\EmailNotificationController::class, 'getPeriodList'])->name('getPeriodList');
     });

    Route::get('/test', [Controller\TestController::class, 'test']);
});

