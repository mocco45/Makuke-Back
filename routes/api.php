<?php
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

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth:sanctum');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class , 'destroy'])->middleware('auth:sanctum');
    
    Route::middleware(['guest'])->group(function(){
        Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    }); 


Route::middleware(['auth:sanctum'])->group(function(){
    Route::controller(\App\Http\Controllers\ApprovalController::class)->group(function(){
        Route::post('/accept/{customer_Loan}', 'acceptupdate');
        Route::post('/reject/{customer_Loan}', 'rejectupdate');
        Route::get('/loan-pending', 'pending');
        Route::get('/loan-pending/{customer_Loan}', 'showPending');
        Route::get('/loan-approval', 'index');
        Route::get('/loan-ongoing', 'ongoing');
        Route::get('/reject', 'rejected');

    });
});


// Route::middleware(['auth:sanctum', 'role:CEO,admin,Manager'])->group(function(){
Route::middleware(['auth:sanctum'])->group(function(){
    Route::controller(\App\Http\Controllers\Auth\RegisteredUserController::class)->group(function(){
        Route::post('/create', 'store')->name('create-user');
        Route::get('/staffs', 'index');
        Route::get('/staff/{user}', 'show');
        Route::get('/staff-edit/{user}', 'edit');
        Route::post('/update/{user}', 'update')->name('update-user');
        Route::delete('/delete/{user}', 'destroy')->name('destroy-user');
        Route::post('/upload-user', 'uploadStaffImage');
    });

    Route::controller(\App\Http\Controllers\Board_MemberController::class)->group(function(){
        Route::post('/create-board', 'store');
        Route::get('/board-members', 'index');
        Route::get('/board-member/{board_member}', 'show');
        Route::post('/board-member-update/{board_member}', 'update');
        Route::delete('/board-member-delete/{board_member}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\BranchController::class)->group(function (){
        Route::get('/branches', 'index');
        Route::post('/branches/create','store');
        Route::get('/branches/{branch}','show');
        Route::delete('branches/{branch}', 'destroy');
    });
});


Route::middleware(['auth:sanctum', 'role:Loan Officer,Manager,admin,CEO'])->group(function(){
    Route::controller(\App\Http\Controllers\CustomersController::class)->group(function(){
        Route::post('/create-customer', 'store');
        Route::get('/customers', 'index');
        Route::get('/customer/{customer}', 'show');
        Route::get('/customer-edit/{customer}', 'edit');
        Route::post('/customer-update/{customer}', 'update');
        Route::delete('/customer-delete/{customer}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\CategoryController::class)->group(function(){
        Route::post('/days', 'store_days');
        Route::post('/interest', 'store_interest');
        Route::post('/form-fee', 'store_form_fee');

        Route::get('/days-list', 'index_days');
        Route::get('/interest-list', 'index_interest');
        Route::get('/form-fee-list', 'index_form_fee');
    });

});

Route::middleware(['auth:sanctum', 'role:Cashier,CEO,Manager,admin'])->group(function(){
    Route::controller(\App\Http\Controllers\PayrollController::class)->group(function(){
        Route::post('/user_allowance/{user}', 'allowance_store');
        Route::post('/user_deduction/{user}', 'deduction_store');
        Route::get('/staff', 'index');
    });

    Route::controller(\App\Http\Controllers\company\ExpenseController::class)->group(function(){
        Route::post('/expense', 'store');
        Route::get('/expense/{expense}', 'show');
        Route::get('/expenses', 'index');
        Route::post('/expense/{expense}', 'update');
        Route::delete('/expense/{expense}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\company\IncomeController::class)->group(function(){
        Route::post('/revenue', 'store');
        Route::get('/revenue/{income}', 'show');
        Route::get('/revenues', 'index');
        Route::post('/revenue/{income}', 'update');
        Route::delete('/revenue/{income}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\BalanceController::class)->group(function (){
        Route::post('/balance', 'store');
        Route::get('/balance', 'index');
    });
    
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function(){
    Route::controller(\App\Http\Controllers\Admin\Payment_MethodController::class)->group(function(){
        Route::post('/payment-method', 'store');
        Route::post('/payment-method/branch/{Branch}', 'perbranch');
        Route::put('/payment-method/{Payment_Method}', 'update');
        Route::delete('/payment-method/{payment_method}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\Payment_TypeController::class)->group(function(){
        Route::post('/payment-type', 'store');
        Route::post('/payment-type/branch/{Branch}', 'perbranch');
        Route::put('/payment-type/{Payment_Type}', 'update');
        Route::delete('/payment-type/{payment_type}', 'destroy');
    });
});

Route::get('/payment-method', [\App\Http\Controllers\Admin\Payment_MethodController::class, 'index'])->middleware('auth:sanctum');
Route::get('/payment-type', [\App\Http\Controllers\Admin\Payment_TypeController::class, 'index'])->middleware('auth:sanctum');

Route::controller(\App\Http\Controllers\LoanPaymentController::class)->group(function(){
    Route::post('/payment/{customer_loan}', 'store');
    Route::get('/payment/{customer_loan}', 'show');
    Route::get('/payments', 'index');
});

Route::middleware('auth:sanctum', 'role:CEO,Director,admin')->controller(\App\Http\Controllers\CEO\StaffController::class)->group(function(){
    Route::get('/allstaff/{branch}', 'index');
}); 
Route::controller(\App\Http\Controllers\RolesController::class)->group(function(){
    Route::get('/roles', 'index');
    Route::get('/roles/{id}', 'show');
});
Route::get('/report', [\App\Http\Controllers\ReportController::class, 'show']);
Route::get('/media', [\App\Http\Controllers\DashboardController::class, 'media'])->middleware('auth:sanctum');
Route::get('/ceo-media', [\App\Http\Controllers\DashboardController::class, 'ceo_media'])->middleware('auth:sanctum');
Route::get('/accounting_expenses', [\App\Http\Controllers\company\AccountingController::class, 'index']);
Route::get('/accounting_assets', [\App\Http\Controllers\company\AccountingController::class, 'index_assets']);
Route::post('/income-report', [\App\Http\Controllers\company\IncomeController::class, 'index_income']);
