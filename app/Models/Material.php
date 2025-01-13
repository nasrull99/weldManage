<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $fillable = [
        'material',
        'price',
      ];

    public function quotation()
    {
      return $this->belongsTo(Quotation::class);
      return $this->belongsToMany(Quotation::class, 'quotation_materials')
      ->withPivot('quantity', 'amount');
    }
}
