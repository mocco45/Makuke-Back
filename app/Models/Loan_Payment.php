<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_Payment extends Model
{
    use HasFactory;
    public $table = 'loan_payment';
    protected $fillable = ['customer_loan_id','amount','payment_type_id','payment_method_id'];

    public function request_delay(){
        return $this->hasMany(Request_Delay::class);
    }

    public function customer_loan(){
        return $this->belongsTo(Customer_Loan::class);
    }

    public function payment_method(){
        return $this->belongsTo(Payment_method::class, 'payment_method_id');
    }

    public function payment_type(){
        return $this->belongsTo(Payment_type::class, 'payment_type_id');
    }

}
