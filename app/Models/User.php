<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
  
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function accomodations(){
        return $this->hasOne(Accomodations::class, 'id', 'sccomodations_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function payroll(){
        return $this->hasMany(Payroll::class, 'id', 'payroll_id');
    }

    public function customer_loan(){
        return $this->hasMany(Customer_Loan::class, 'id', 'customer_loan_id');
    }

    public function financials(){
        return $this->hasMany(Financials::class, 'id', 'financials_id');
    }
}