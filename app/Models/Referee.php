<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referee extends Model
{
    use HasFactory;

    public $table = 'referee';

    protected $guarded = [];

    public function getPhotoRefAttribute($value){
        return asset('storage/images/referee/'.$value);
    }

    public function referee_guarantee(){
        return $this->hasMany(Referee_Guarantee::class);
    }

    public function customer_loan(){
        return $this->belongsTo(Customer_Loan::class);
    }

    public function customer(){
        return $this->belongsTo(Customers::class);
    }
}
