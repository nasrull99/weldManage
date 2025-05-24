<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'custdetail'; // Table name

    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'location',
        'status',
        'user_id',
        'datetime',
        'description',
        'image',
    ];

    // Define the relationship with quotations
    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'customer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'customer_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }
}