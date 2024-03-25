<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public $table = 'branch';

    protected $guarded = [];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function getroleIdAttribute(){
        if($this->user && $this->user->role){
            return $this->user->role->name;
        }
        else{
            return 'hellow';
        }
    }

    public function customer_loan(){
        return $this->hasMany(Customer_Loan::class);
    }

    public function payment_type(){
        return $this->belongsToMany(Payment_type::class);
    }

    public function payment_method(){
        return $this->belongsToMany(Payment_method::class);
    }

    
}
