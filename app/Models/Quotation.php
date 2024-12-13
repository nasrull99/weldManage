<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 
        'material_id', 
        'quantity', 
        'amount',
    ];

    // Relationship with Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relationship with Material model
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
