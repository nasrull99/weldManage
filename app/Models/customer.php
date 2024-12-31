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
    ];

    // Define the relationship with quotations
    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'customer_id'); // Ensure the foreign key is 'customer_id' in the quotations table
    }
}