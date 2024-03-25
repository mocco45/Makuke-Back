<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    protected $fillable = ['duration'];

    public $table = 'days';

    use HasFactory;

    public function customer_loan(){
        return $this->hasOne(Customer_Loan::class);
    }
}
