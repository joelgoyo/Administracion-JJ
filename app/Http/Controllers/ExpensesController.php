<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;

class ExpensesController extends Controller
{
    public function save(Request $request){
        $products = Expenses::create([
            'description_expenses' => $request->description_expenses,
            'payment_amount' => $request->payment_amount,
            'payment_type' => $request->payment_type
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Datos del producto guardados correctamente',
        ]);
    }

    public function list(){
        $expenses = Expenses::get();
        return response()->json([
            'status' => 200,
            'expenses' => $expenses
        ]);
    }

    public function delete($id){
        Expenses::where('id', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Tabla de gasto eliminado correctamente',
        ]);
    }
}
