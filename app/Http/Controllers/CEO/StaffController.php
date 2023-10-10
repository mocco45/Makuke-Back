<?php

namespace App\Http\Controllers\CEO;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Branch $branch){
        // $branches = Branch::where('id', $branch)->first();
        $list = Branch::with(
            'user',
            'user.role',
            'customer_loan',
            'customer_loan.customer',
            'customer_loan.customer_guarantee',
            'customer_loan.referee',
            'customer_loan.referee.referee_guarantee'
            )->find($branch->id);

            // $branch->setRelation('user', $branch->user->makeHidden(['role_id'])->append(['role_name']));

        return response()->json($list);
    }
}
