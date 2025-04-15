<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    
    protected $table = 'invoices';

    protected $fillable = [
        'customer_id', 
        'totalamount', 
        'subtotal',
        'deposit'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relationship with QuotationMaterial model (intermediary table for materials)
     */
    public function invoiceMaterials()
    {
        return $this->hasMany(InvoicesnMaterial::class, 'invoice_id');
    }

    /**
     * Relationship with Material model (via pivot table)
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'invoice_materials')
                    ->withPivot('quantity', 'amount');
    }
}
