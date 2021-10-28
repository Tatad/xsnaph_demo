<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', [\App\Http\Controllers\XeroController::class, 'index'])->name('xero.auth.success');
Route::get('/xero-connects', [\App\Http\Controllers\XeroController::class, 'success'])->name('xero.auth.success');
Route::get('/delete-org/{id}',  [\App\Http\Controllers\XeroController::class, 'deleteOrg']);
//Auth::routes();
	//Route::get('/', [HomeController::class, 'index'])->name('home');
	Route::get('/sales-journal-report',  [\App\Http\Controllers\ReportsController::class, 'salesJournal']);
	Route::get('/purchases-journal-report',  [\App\Http\Controllers\ReportsController::class, 'purchasesJournal']);
	Route::post('/get-journal-data',  [\App\Http\Controllers\ReportsController::class, 'getJournalData']);

//Auth::routes();
Route::get('/register', [\App\Http\Controllers\XeroController::class, 'register'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/select-org/{any}', [App\Http\Controllers\XeroController::class, 'selectOrg'])->name('selectOrg');
Route::post('/register-org', [App\Http\Controllers\XeroController::class, 'registerOrg'])->name('registerOrg');
Route::get('/logout-org', [App\Http\Controllers\XeroController::class, 'logoutOrg'])->name('logoutOrg');
Route::post('/download-journal', [App\Http\Controllers\JournalController::class, 'downloadJournalReport'])->name('downloadJournalReport');
