<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'code',
        'supplier_id',
        'name',
        'description',
        'priceSupplier',
        'priceUnit',
        'expirationDate',
        'stock',
        'weight',
        'image',
        'status',
    ];
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
