<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer_loan(){
        return $this->hasMany(Customer_Loan::class, 'id', 'customer_loan_id');
    }

    public function getPhotoAttribute($value){
        return asset('storage/app/public/images/customers/'.$value);
    }

}
