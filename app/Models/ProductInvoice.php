<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvoice extends Model
{
    use HasFactory;

    protected $table = 'product_invoices';

    protected $fillable = [
        'product_id',
        'bill_id',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
