<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'accountingCode',
        'account',
        'category',
        'subCategory',
        'employee_id',
        'service',
        'description',
        'type',
        'balance',
        'date',
    ];
}
