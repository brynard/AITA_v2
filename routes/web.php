<?php

use Illuminate\Support\Facades\Route;

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
	return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuditController;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
//Projects 
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{project}/{readOnly}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');


//Project Details
Route::get('/projects/{project}/{readOnly}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/projects/{project}/items', [ProjectController::class, 'storeItem'])->name('projects.storeItem');
Route::get('/projects/{project}/items/create', [ProjectController::class, 'createItem'])->name('projects.createItem');
Route::get('/projects/{project}/items/{detail}/{readOnly?}', [ProjectController::class, 'edit'])->name('projects.editItem');
Route::put('/projects/{project}/items/{detail}/{readOnly?}', [ProjectController::class, 'updateItem'])->name('projects.updateItem');
Route::delete('/projects/{project}/items/{detail}/{readOnly?}', [ProjectController::class, 'destroyItem'])->name('projects.deleteItem');
// Route::get('/testing', [ProjectController::class, 'test'])->name('test');

//Loan
Route::get('/loan', [LoanController::class, 'index'])->name('loan');
Route::post('/loan/requestLoan', [LoanController::class, 'requestLoan'])->name('loan.requestLoan');
Route::delete('/loan/cancelLoan', [LoanController::class, 'cancelLoanRequest'])->name('loan.cancelLoanRequest');
Route::put('/loan/processPending', [LoanController::class, 'processPendingRequest'])->name('loan.processPendingRequest');
Route::put('/loan/updateStatus', [LoanController::class, 'updateReturnStatus'])->name('loan.updateReturnStatus');

//Report
Route::get('/report', [ReportController::class, 'index'])->name('report');
Route::get('/report/ItemOverview', [ReportController::class, 'itemOverview'])->name('report.itemOverview');
Route::get('/report/LoanOverview', [ReportController::class, 'LoanOverview'])->name('report.LoanOverview');
Route::get('/report/userActivity', [ReportController::class, 'userActivity'])->name('report.userActivity');


//Audit
Route::get('/userManagement', [AuditController::class, 'index'])->name('userManagement');
Route::get('/userManagement/{project}', [AuditController::class, 'show'])->name('userManagement.project');



Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');

	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
});
