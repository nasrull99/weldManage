<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceMaterial extends Model
{
    protected $table = 'invoice_materials';

    protected $fillable = [
        'invoice_id', 
        'material_id', 
        'quantity', 
        'amount'
    ];

    // Relationship with invoices model
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    // Relationship with Material model
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
