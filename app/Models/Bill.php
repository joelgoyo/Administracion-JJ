<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'order',
        'PlaceIssue',
        'date',
        'typeDelivery',
        'typePayment',
        'bank',
        'deliveryNote',
        'deliveryDate',
        'status',
        'amount',
        'amount_bs',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function productInvoice()
    {
        return $this->hasMany(ProductInvoice::class);
    }

    public function products()
    {
        return $this->belongsToMany(products::class, 'product_invoices', 'bill_id', 'product_id')
                ->withTimestamps();
 }
}
