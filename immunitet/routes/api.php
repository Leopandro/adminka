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
});
Route::get('/user/profile', [Controller\AuthController::class, 'user']);
Route::middleware(['auth:sanctum'])->group(function () {
     Route::name('company.')->prefix('company')->group(function() {
         Route::get('get', [Controller\CompanyController::class, 'getByUser'])->name('getByUser');
         Route::post('create', [Controller\CompanyController::class, 'createOrUpdateByUser'])->name('createOrUpdateByUser');
         Route::post('update', [Controller\CompanyController::class, 'createOrUpdateByUser'])->name('createOrUpdateByUser');
         Route::post('delete', [Controller\CompanyController::class, 'updateByUser'])->name('deleteByUser');
     });
     Route::name('payment.')->prefix('payment')->group(function() {
         Route::post('cryptogram_payment', [Controller\PaymentController::class, 'create'])->name('cryptogramPayment');
     });
});
