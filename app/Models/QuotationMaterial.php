<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationMaterial extends Model
{
    use HasFactory;
    protected $table = 'quotation_materials';
    protected $fillable = [
        'quotation_id',
        'material_id',
        'quantity',
        'amount',
    ];

    // Relationship with Quotation model
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    // Relationship with Material model
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
