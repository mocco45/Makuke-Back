<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referee_Guarantee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $table = 'referee_guarantee';

    public function referee(){
        return $this->belongsTo(Referee::class);
    }
}
