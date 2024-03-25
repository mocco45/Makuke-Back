<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;

    protected $fillable = ['payment_method'];

    public $table = 'payment_method';

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
