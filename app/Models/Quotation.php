<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';
    protected $fillable = [
        'customer_id', 
        'totalamount',
    ];

    // Relationship with Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
        return $this->belongsTo(Customer::class);
    }

    // Relationship with QuotationMaterial model
    public function materials()
    {
        return $this->hasMany(QuotationMaterial::class, 'quotation_id');
        return $this->hasMany(Material::class);
    }
}