<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Guarantee extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $table = 'customer_guarantee';

    public function customer_loan(){
        return $this->belongsTo(Customer_Loan::class);
    }
}
