<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejected_reasons extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer_loan(){
        return $this->belongsTo(Customer_Loan::class);
    }
}
