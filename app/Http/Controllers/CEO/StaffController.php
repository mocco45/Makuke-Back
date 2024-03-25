<?php

namespace App\Http\Controllers\CEO;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class StaffController extends Controller
{
    public function index(Branch $branch){
        $list = Branch::with(
            'user',
            'user.role',
            'customer_loan',
            'customer_loan.customer',
            'customer_loan.customer_guarantee',
            'customer_loan.referee',
            'customer_loan.referee.referee_guarantee',
            'payment_type',
            'payment_method'
            )->find($branch->id);

            // $branch->setRelation('user', $branch->user->makeHidden(['role_id'])->append(['role_name']));

        return response()->json($list);
    }
}
