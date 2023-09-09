<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_Delay extends Model
{
    use HasFactory;

    public function loan_payment(){
        return $this->belongsTo(Loan_Payment::class);
    }
}
