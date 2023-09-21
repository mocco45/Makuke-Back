<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'category';

    public function customer_loan(){
        return $this->hasOne(Customer_Loan::class, 'id', 'customer_loan_id');
    }
}
