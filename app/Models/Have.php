<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Have extends Model
{
    use HasFactory;

    protected $table = 'haves';

    protected $fillable = [
        'amount',
        'expense_id',
    ];

    public function expense()
    {
        return $this->belongsTo(Expenses::class);
    }
    
}
