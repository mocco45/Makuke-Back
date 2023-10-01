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

Route::post('/upload-customer', [\App\Http\Controllers\CustomersController::class, 'uploadCustomerImage'])->name('image.upload');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class , 'destroy'])->name('logout');
    


    Route::middleware(['guest'])->group(function(){
        Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    }); 


Route::middleware(['auth:sanctum', 'role:Manager,CEO,admin'])->group(function(){
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


Route::middleware(['auth:sanctum', 'role:CEO,admin,Manager'])->group(function(){
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
        Route::post('/create-customer/{customers?}', 'store');
        Route::get('/customers', 'index');
        Route::get('/customer/{customer}', 'show');
        Route::get('/customer-edit/{customer}', 'edit');
        Route::post('/customer-update/{customer}', 'update');
        Route::delete('/customer-delete/{customer}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\CategoryController::class)->group(function(){
        Route::get('/category-list', 'index');
        Route::get('/category/{category}', 'show');
        Route::get('/category/{category}/edit', 'edit');
        Route::post('/category/{category}/update', 'update');
        Route::delete('/category/{category}/delete', 'delete');
        // Route::post('/category/{category}/store', 'store');
        Route::post('/category', 'store');
    });

    Route::controller(\App\Http\Controllers\CategoryController::class)->group(function(){
        Route::get('/category-list', 'index');
        Route::get('/category/{category}', 'show');
        Route::get('/category/{category}/edit', 'edit');
        Route::post('/category/{category}/update', 'update');
        Route::delete('/category/{category}/delete', 'delete');
        Route::post('/category', 'store');
    });

});
Route::middleware(['auth:sanctum', 'role:Cashier'])->group(function(){
    Route::controller(\App\Http\Controllers\PayrollController::class)->group(function(){
        Route::post('/user_allowance/{user}', 'allowance_store');
        Route::post('/user_deduction/{user}', 'deduction_store');
        Route::get('/staff', 'index');
    });
    
});

Route::controller(\App\Http\Controllers\LoanPaymentController::class)->group(function(){
    Route::post('/payment/{customer_loan}', 'store');
    Route::get('/payment/{customer_loan}', 'show');
    Route::get('/payments', 'index');
});
Route::post('/change-password', [\App\Http\Controllers\Auth\ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::middleware('auth:sanctum','role:CEO')->controller(\App\Http\Controllers\CEO\StaffController::class)->group(function(){
    Route::get('/allstaff/{branch}', 'index');
}); 
Route::get('/roles',[\App\Http\Controllers\RolesController::class, 'index']);
Route::get('/roles/{id}', [\App\Http\Controllers\RolesController::class, 'show']);


