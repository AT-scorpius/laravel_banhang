<?php

namespace App\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customer";
    protected $fillable = [
        'name',
        'gender',
        'email',
        'address',
        'phone_number',
        'note',
    ];
}
