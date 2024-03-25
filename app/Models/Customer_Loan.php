<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'customer_loan';

    public function calculateDueDate()
    {
        $dueDate = $this->created_at->copy(); 
        $dueDate->addMonths($this->repayment_time);
        return $dueDate;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function referee(){
        return $this->hasMany(Referee::class, 'customer_loan_id');
    }

    public function loan_payment(){
        return $this->hasMany(Loan_Payment::class, 'customer_loan_id');
    }

    public function customer(){
        return $this->belongsTo(Customers::class);
    }

    public function customer_guarantee(){
        return $this->hasMany(Customer_Guarantee::class, 'customer_loan_id');
    }

    public function rejected_reasons(){
        return $this->hasMany(rejected_reasons::class, 'customer_loan_id');
    }

    public function day(){
        return $this->belongsTo(Days::class);
    }

    public function formfee(){
        return $this->belongsTo(Fee::class);
    }

    public function interest(){
        return $this->belongsTo(Interest::class);
    }
}
