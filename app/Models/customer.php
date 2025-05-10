<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'custdetail'; // Table name

    protected $fillable = [
        'name',
        'phone',
        'location',
        'status',
        'user_id',
    ];

    // Define the relationship with quotations
    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'customer_id'); // Ensure the foreign key is 'customer_id' in the quotations table
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