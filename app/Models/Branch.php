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
        return $this->belongsTo(User::class);
    }
}
