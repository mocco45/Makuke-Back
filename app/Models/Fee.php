<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    
    protected $fillable = ['percent']; 

    public $table = 'formfee';

    public function customer_loan(){
        return $this->hasOne(Customer_Loan::class);
    }
}
