<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Products;
use App\Models\Client;

class BillingController extends Controller
{
    public function index()
    {     
        $billing = Bill::with('products')->get();
        return response()->json([
            'status' => 200,
            'billing' => $billing,
            'message' => 'Operación realizada correctamente',
        ]);
    }
}

