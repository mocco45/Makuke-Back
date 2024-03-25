<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payment_method(){
        return $this->belongsTo(Payment_method::class);
    }

    public function payment_type(){
        return $this->belongsTo(Payment_type::class);
    }

    public function account_name(){
        return $this->belongsTo(AccountNames::class);
    }

    public function account_category(){
        return $this->belongsTo(AccountCategories::class);
    }
}
