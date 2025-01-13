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

    /**
     * Relationship with Customer model
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relationship with QuotationMaterial model (intermediary table for materials)
     */
    public function quotationMaterials()
    {
        return $this->hasMany(QuotationMaterial::class, 'quotation_id');
    }

    /**
     * Relationship with Material model (via pivot table)
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'quotation_materials')
                    ->withPivot('quantity', 'amount');
    }
}