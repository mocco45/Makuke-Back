<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Board_MemberController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\company\ExpenseController;
use App\Http\Controllers\company\IncomeController;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\payrol\AllowanceController;
use App\Http\Controllers\payrol\DeductionsController;
use App\Models\Board_Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware(['auth:sanctum'])->post('/upload', [ImageUploadController::class, 'upload'])->name('image.upload');
Route::post('/upload-customer', [CustomersController::class, 'uploadCustomerImage'])->name('image.upload');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload-user', [RegisteredUserController::class, 'uploadStaffImage']);

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    
    Route::controller(BranchController::class)->group(function (){
        Route::get('/branches', 'index');
        Route::post('/branches/create','store');
        Route::get('/branches/{branch}','show');
        Route::delete('branches/{branch}', 'destroy');
    });
    Route::controller(RegisteredUserController::class)->group(function(){
        Route::post('/create', 'store')->name('create-user');
        Route::get('/staffs', 'index');
        Route::get('/staff/{user}', 'show');
        Route::get('/staff-edit/{user}', 'edit');
        Route::post('/staff-update/{user}', 'update')->name('update-user');
        Route::delete('/delete/{user}', 'destroy')->name('destroy-user');
    });

    Route::controller(CustomersController::class)->group(function(){
        Route::post('/create-customer', 'store');
        Route::get('/customers', 'index');
        Route::get('/customer/{customer}', 'show');
        Route::get('/customer-edit/{customer}', 'edit');
        Route::post('/customer-update/{customer}', 'update');
        Route::delete('/customer-delete/{customer}', 'destroy');
    });
    
    Route::controller(Board_MemberController::class)->group(function(){
        Route::post('/create-board', 'store');
        Route::get('/board-members', 'index');
        Route::get('/board-member/{board_member}', 'show');
        Route::post('/board-member-update/{board_member}', 'update');
        Route::delete('/board-member-delete/{board_member}', 'destroy');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category-list', 'index');
        Route::get('/category/{category}', 'show');
        Route::get('/category/{category}/edit', 'edit');
        Route::post('/category/{category}/update', 'update');
        Route::delete('/category/{category}/delete', 'delete');
        Route::post('/category/{category}/store', 'store');
    });

    Route::post('/logout', [LoginController::class , 'destroy'])->name('logout');

});

    Route::middleware(['guest'])->group(function(){
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    }); 


Route::middleware(['auth:sanctum', 'CEO' , 'admin'])->group(function(){

});
Route::middleware(['auth:sanctum', 'Manager' , 'admin'])->group(function(){

});
Route::middleware(['auth:sanctum', 'Cashier' , 'admin'])->group(function(){

});
Route::middleware(['auth:sanctum', 'Loan-Officer' , 'admin'])->group(function(){

});

Route::get('/roles',[RolesController::class, 'index']);
Route::get('/roles/{id}', [RolesController::class, 'show']);



Route::resources([
    'allowance' => AllowanceController::class,
    'deduction' => DeductionsController::class,
]);

Route::resources([
    'expense' => ExpenseController::class,
    'income' => IncomeController::class,
]);

