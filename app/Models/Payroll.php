<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    public $table = 'payroll';


    public function user(){
        return $this->belongsTo(User::class);
    }
}
