<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer_guarantee(){
        return $this->hasMany(Customer_Guarantee::class);
    }

    public function customer_loan(){
        return $this->hasMany(Customer_Loan::class);
    }

}
