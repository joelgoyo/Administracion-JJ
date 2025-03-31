<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SuppliersController extends Controller
{
    public function save(Request $request){
        $supplier = Supplier::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Proveedor creado correctamente',
        ]);
    }
    public function list(){
        $suppliers = Supplier::get();
        return response()->json([
            'status' => 200,
            'suppliers' => $suppliers
        ]);
    }
    public function checkEmail($email){
        $supplier = Supplier::where('email', $email)->exists();
        if ($supplier) {
            return response()->json([
                'status' => 200,
                'exists' => true,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'exists' => false,
            ]);
        }
    }
    public function checkName($name){
        $supplier = Supplier::where('name', $name)->exists();
        if ($supplier) {
            return response()->json([
                'status' => 200,
                'exists' => true,
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'exists' => false,
            ]);
        }
    }
    public function delete($id){
        Supplier::where('id', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Proveedor eliminado correctamente',
        ]);
    }
    public function update(Request $request, $id){
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->dni = $request->dni;
        $supplier->save();
        return response()->json([
            'status' => 200,
            'message' => 'Proeveedor actualizado correctamente',
        ]);
    }
}

