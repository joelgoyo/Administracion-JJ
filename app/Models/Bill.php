<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'PlaceIssue',
        'date',
        'typeDelivery',
        'typePayment',
        'bank',
        'deliveryNote',
        'deliveryDate',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
