<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{ 
    protected $fillable = ['percent'];

    public $table = 'interest';

    use HasFactory;

    public function customer_loan(){
        return $this->hasOne(Customer_Loan::class);
    }
}
