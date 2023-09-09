<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'customer_loan';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function referee(){
        return $this->hasMany(Referee::class);
    }

    public function loan_payment(){
        return $this->hasMany(Loan_Payment::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function category(){
        return $this->hasOne(Category::class);
    }
}
