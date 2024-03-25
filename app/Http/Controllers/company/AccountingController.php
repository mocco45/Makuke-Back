<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\AccountCategories;
use App\Models\AccountNames;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index(){
        $payables = AccountNames::whereBetween('code', [2010,2014])->get();
        $interest_pay = AccountNames::whereBetween('code', [2110,2150])->get();
        $client_depo = AccountNames::whereBetween('code', [2210,2230])->get();
        $loans_pay = AccountNames::whereBetween('code', [2320,2350])->get();
        $financing = AccountNames::whereBetween('code', [5010,5030])->get();
        $loss_prov = AccountNames::whereBetween('code', [5110,5120])->get();
        $personel = AccountNames::whereBetween('code', [5210,5250])->get();
        $office = AccountNames::whereBetween('code', [5310,5332])->get();
        $occupancy = AccountNames::whereBetween('code', [5410,5430])->get();
        $travel = AccountNames::whereBetween('code', [5510,5550])->get();
        $equip = AccountNames::whereBetween('code', [5610,5650])->get();
        $prog = AccountNames::whereBetween('code', [5710,5740])->get();
        $misc = AccountNames::whereBetween('code', [5810,5820])->get();
        $non_op = AccountNames::whereBetween('code', [5910,5990])->get();
        $liability = AccountCategories::whereBetween('code', [2000,2300])->get();
        $expenses = AccountCategories::whereBetween('code', [5000,5900])->get();
        
        return response()->json([
            'liabilities' => $liability,
            'expenses' => $expenses,
            [
            'id' => 9,
            'code' => 2000, 
            'value' => $payables
            ],
            [
            'id' => 10,    
            'code' => 2100, 
            'value' => $interest_pay
            ],
            [
            'id' => 11,
            'code' => 2200, 
            'value' => $client_depo
            ],
            [
            'id' => 12,
            'code' => 2300, 
            'value' => $loans_pay
            ],
            [
            'id' => 13,
            'code' => 5000, 
            'value' => $financing
            ],
            [
            'id' => 14,
            'code' => 5100, 
            'value' => $loss_prov
            ],
            [
            'id' => 15,
            'code' => 5200, 
            'value' => $personel
            ],
            [
            'id' => 16,
            'code' => 5300, 
            'value' => $office
            ],
            [
            'id' => 17,
            'code' => 5400, 
            'value' => $occupancy
            ],
            [
            'id' => 18,
            'code' => 5500, 
            'value' => $travel
            ],
            [
            'id' => 19,
            'code' => 5600, 
            'value' => $equip
            ],
            [
            'id' => 20,
            'code' => 5700, 
            'value' => $prog
            ],
            [
            'id' => 21,
            'code' => 5800, 
            'value' => $misc
            ],
            [
            'id' => 22,
            'code' => 5900, 
            'value' => $non_op
            ]
        ]);
    }

    public function index_assets(){
        $cash = AccountNames::whereBetween('code', [1000,1100])->get();
        $loan = AccountNames::whereBetween('code', [1210,1240])->get();
        $reserve = AccountNames::whereBetween('code', [1310,1320])->get();
        $interest_loan = AccountNames::whereBetween('code', [1410,1459])->get();
        $receivable = AccountNames::whereBetween('code', [1510,1530])->get();
        $long_term = AccountNames::whereBetween('code', [1610,1612])->get();
        $property = AccountNames::whereBetween('code', [1710,1751])->get();
        $other_assets = AccountNames::whereBetween('code', [1800,1810])->get();
        $assets = AccountCategories::whereBetween('code', [1000,1800])->get();
        $asset_names = AccountNames::whereBetween('code', [1000,1810])->get();

        return response()->json([
            'asset' => $assets,
            'assetNames' => $asset_names,
            [
            'id' => 1,
            'code' => 1000,
            'value' => $cash
            ],
            [
            'id' => 2,
            'code' => 1200, 
            'value' => $loan
            ],
            [
            'id' => 3,
            'code' => 1300, 
            'value' => $reserve
            ],
            [
            'id' => 4,
            'code' => 1400, 
            'value' => $interest_loan
            ],
            [
            'id' => 5,
            'code' => 1500, 
            'value' => $receivable
            ],
            [
            'id' => 6,
            'code' => 1600, 
            'value' => $long_term
            ],
            [
            'id' => 7,
            'code' => 1700, 
            'value' => $property
            ],
            [
            'id' => 8,
            'code' => 1800, 
            'value' => $other_assets
            ]
        ]);

    }
}
