<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function save(Request $request){
        $products = Products::create([
            'code' => $request->code,
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'description' => $request->description,
            'priceSupplier' => $request->provider_price,
            'priceUnit' => $request->price,
            'expirationDate' => $request->expiration,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'image' => $request->image,
        ]);
    
        return response()->json([
            'status' => 200,
            'message' => 'Datos del producto guardados correctamente',
        ]);
    }
    public function list(){
        $products = Products::get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
    public function checkCode($code){
        $products = Products::where('code', $code)->exists();
        if ($products) {
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
        $products = Products::where('name', $name)->exists();
        if ($products) {
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
        Products::where('id', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Producto eliminado correctamente',
        ]);
    }
    public function update(Request $request, $id){
        $products = Products::find($id);
        $products->code = $request->code;
        $products->supplier_id = $request->supplier_id;
        $products->name = $request->name;
        $products->description = $request->description;
        $products->priceSupplier = $request->priceSupplier;
        $products->priceUnit = $request->priceUnit;
        $products->expirationDate = $request->expirationDate;
        $products->stock = $request->stock;
        $products->weight = $request->weight;
        $products->image = $request->image;
        $products->save();
        return response()->json([
            'status' => 200,
            'message' => 'Proeveedor actualizado correctamente',
        ]);
    }
    public function productsCount(){
        $products = Products::count();
        return response()->json(
			[
				'status' => 200,
				'products' => $products,
				'message' => 'Operación realizada correctamente',
			]
        );
    }
}

