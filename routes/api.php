<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Board_MemberController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\company\ExpenseController;
use App\Http\Controllers\company\IncomeController;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\payrol\AllowanceController;
use App\Http\Controllers\payrol\DeductionsController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StaffController;
use App\Models\Board_Member;
use App\Models\Payroll;
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


Route::post('/refresh-token', function (Request $request) {
    $user = $request->user();
    $user->tokens->each->delete();

    $token = $user->createToken('token-name')->plainTextToken;

    return response()->json(['token' => $token]);
})->middleware(['auth:sanctum']);

Route::post('/upload-customer', [CustomersController::class, 'uploadCustomerImage'])->name('image.upload');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/logout', [LoginController::class , 'destroy'])->name('logout');
    


    Route::middleware(['guest'])->group(function(){
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    }); 


Route::middleware(['auth:sanctum', 'role:Manager,CEO,admin'])->group(function(){
    Route::controller(ApprovalController::class)->group(function(){
        Route::post('/accept/{customer_Loan}', 'acceptupdate');
        Route::post('/reject/{customer_Loan}', 'rejectupdate');
        Route::get('/loan-pending', 'pending');
        Route::get('/loan-approval', 'index');
    });
});


Route::middleware(['auth:sanctum', 'role:CEO,admin,Manager'])->group(function(){
    Route::controller(RegisteredUserController::class)->group(function(){
        Route::post('/create', 'store')->name('create-user');
        Route::get('/staffs', 'index');
        Route::get('/staff/{user}', 'show');
        Route::get('/staff-edit/{user}', 'edit');
        Route::post('/update/{user}', 'update')->name('update-user');
        Route::delete('/delete/{user}', 'destroy')->name('destroy-user');
        Route::post('/upload-user', 'uploadStaffImage');
    });

    Route::controller(Board_MemberController::class)->group(function(){
        Route::post('/create-board', 'store');
        Route::get('/board-members', 'index');
        Route::get('/board-member/{board_member}', 'show');
        Route::post('/board-member-update/{board_member}', 'update');
        Route::delete('/board-member-delete/{board_member}', 'destroy');
    });

    Route::controller(BranchController::class)->group(function (){
        Route::get('/branches', 'index');
        Route::post('/branches/create','store');
        Route::get('/branches/{branch}','show');
        Route::delete('branches/{branch}', 'destroy');
    });
});


Route::middleware(['auth:sanctum', 'role:Loan-Officer,Manager,admin,CEO'])->group(function(){
    Route::controller(CustomersController::class)->group(function(){
        Route::post('/create-customer', 'store');
        Route::get('/customers', 'index');
        Route::get('/customer/{customer}', 'show');
        Route::get('/customer-edit/{customer}', 'edit');
        Route::post('/customer-update/{customer}', 'update');
        Route::delete('/customer-delete/{customer}', 'destroy');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category-list', 'index');
        Route::get('/category/{category}', 'show');
        Route::get('/category/{category}/edit', 'edit');
        Route::post('/category/{category}/update', 'update');
        Route::delete('/category/{category}/delete', 'delete');
        Route::post('/category/{category}/store', 'store');
    });

});
Route::middleware(['auth:sanctum', 'role:admin,Cashier'])->group(function(){
    Route::controller(PayrollController::class)->group(function(){
        Route::post('/user_allowance/{user}', 'allowance_store');
        Route::post('/user_deduction/{user}', 'deduction_store');
        Route::get('/staff', 'index');
    });
    
});

Route::resource('allowance', AllowanceController::class);
Route::resource('deduction', DeductionController::class);

Route::get('/roles',[RolesController::class, 'index']);
Route::get('/roles/{id}', [RolesController::class, 'show']);


