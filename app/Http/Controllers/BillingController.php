<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Products;
use App\Models\Client;
use App\Models\ProductInvoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function list(){     
        $billing = Bill::with('client')->get();
        return response()->json([
            'status' => 200,
            'billing' => $billing,
        ]);
    }

    public function save(Request $request){
        $billing = new Bill();
        $billing->client_id = $request->client_id;
        $billing->order = $request->order;
        $billing->PlaceIssue = $request->PlaceIssue;
        $billing->date = $request->date;
        $billing->typeDelivery = $request->typeDelivery;
        $billing->typePayment = $request->typePayment;
        $billing->amount = $request->amount;
        $billing->amount_bs = $request->amount_bs;
        $billing->bank = $request->bank;
        $billing->deliveryNote = $request->deliveryNote;
        $billing->deliveryDate = $request->deliveryDate;
        $billing->status = $request->status;
        $billing->save();

        return response()->json([
            'status' => 200,
            'billing' => $billing,
            'message' => 'Operación realizada correctamente',
        ]);
    }
    
    public function saveBillingProducts(Request $request) {
        $products = $request->input('products'); 
    
        if (is_array($products)) {
            foreach ($products as $productData) {
                $billingProduct = new ProductInvoice();
                $billingProduct->product_id = $productData['product_id'];
                $billingProduct->bill_id = $productData['bill_id'];
                $billingProduct->save();
            }
    
            return response()->json([
                'status' => 200,
                'message' => 'Productos de la factura guardados correctamente',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Error: No se recibió un array de productos válido.',
            ]);
        }
    }

    public function listInvoice(){
        $ProductInvoice = ProductInvoice::with('product','bill.client')->get();
        return response()->json([
            'status' => 200,
            'ProductBilling' => $ProductInvoice,
        ]);
    }

    public function delete($id){
        $billing = Bill::find($id);
        $billing->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Operación realizada correctamente',
        ]);
    }

    public function updateStock(Request $request)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validación fallida',
                'messages' => $validator->errors(),
            ], 422);
        }

        // Obtener los datos validados
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Iniciar una transacción para garantizar la integridad de los datos
        return DB::transaction(function () use ($productId, $quantity) {
            // Buscar el producto
            $product = Products::findOrFail($productId);

            // Verificar si hay suficiente stock
            if ($product->stock < $quantity) {
                return response()->json([
                    'error' => 'Stock insuficiente',
                    'message' => "El producto {$product->name} solo tiene {$product->stock} unidades disponibles.",
                ], 400);
            }

            // Restar la cantidad del stock
            $product->stock -= $quantity;

            // Guardar los cambios
            $product->save();

            return response()->json([
                'message' => 'Stock actualizado correctamente',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock,
                ],
            ], 200);
        });
    }
}

