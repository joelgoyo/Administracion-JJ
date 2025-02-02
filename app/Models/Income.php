<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';

    protected $fillable = [
        'bill_id',
        'description',
        'type',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
