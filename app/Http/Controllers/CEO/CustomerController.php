<?php

namespace App\Http\Controllers\CEO;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Branch $branch){
        $list = $branch->with(
            [
                'user',
                'user.customer_loan',
                'user.customer_loan.customer',
                'user.customer_loan.customer', 
            ]);
    }
}
