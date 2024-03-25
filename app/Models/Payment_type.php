<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_type extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type', 'type'];

    public $table = 'payment_type';

    public function loan_payment(){
        return $this->hasMany(Loan_Payment::class);
    }

    public function branch(){
        return $this->belongsToMany(Branch::class);
    }

    public function income(){
        return $this->hasOne(Income::class);
    }

    public function expense(){
        return $this->hasOne(Expense::class);
    }
}
