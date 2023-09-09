<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_Payment extends Model
{
    use HasFactory;

    public function request_delay(){
        return $this->hasMany(Request_Delay::class);
    }

    public function customer_loan(){
        return $this->belongsTo(Customer_Loan::class);
    }
}
