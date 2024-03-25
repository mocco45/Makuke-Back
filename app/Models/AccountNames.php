<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountNames extends Model
{
    use HasFactory;

    public $table = 'account_names';

    protected $guarded = [];

    public function income(){
        return $this->hasOne(Income::class);
    }

    public function expense(){
        return $this->hasOne(Expense::class);
    }
}
