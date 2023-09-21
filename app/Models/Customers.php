<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer_loan(){
        return $this->hasMany(Customer_Loan::class,'id', 'customer_id');
    }

    // Accessor method to get the full name
    public function getFullNameAttribute()
    {
        return $this->attributes['firstName'] . ' ' . $this->attributes['lastName'];
    }

    // Method to get the full image path
    public function getPhotoPathAttribute()
    {
        // Assuming your images are stored in a 'photos' directory within the public directory
        $photoPath = 'storage/images/customers' . $this->attributes['photo'];

        // You can also use the asset function to generate the full URL
        return asset($photoPath);


    }

}