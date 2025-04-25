<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Products;
use App\Models\Client;
use App\Models\ProductInvoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller {
    public function index(Request $request){
        $billId = $request->query('bill_id');

        if (!$billId) {
            $billProducts = ProductInvoice::with(['bill', 'product'])->get();
            return response()->json([
                'ProductBilling' => $billProducts
            ]);
        }

        $billProducts = ProductInvoice::with(['product'])
            ->where('bill_id', $billId)
            ->get();

        if ($billProducts->isEmpty()) {
            return response()->json([
                'bill_id' => $billId,
                'products' => []
            ], 404);
        }

        // Aquí mapeamos los datos deseados
        $products = $billProducts->map(function ($bp) {
            return [
                'id' => $bp->product->id,
                'code' => $bp->product->code,
                'name' => $bp->product->name,
                'description' => $bp->product->description,
                'price_unit' => $bp->product->priceUnit,
            ];
        });

        return response()->json([
            'bill_id' => $billId,
            'products' => $products
        ]); 
    }

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

    public function getClientsWithBillsAndProducts()
    {
        // Cargar todos los clientes con sus facturas y los productos de cada factura
        $clients = Client::with(['bills.productInvoices.product'])->get();

        // Transformar los datos para la respuesta JSON
        $response = $clients->map(function ($client) {
            return [
                'client_id' => $client->id,
                'client_name' => $client->name,
                'client_last_name' => $client->last_name,
                'bills' => $client->bills->map(function ($bill) {
                    return [
                        'bill_id' => $bill->id,
                        'created_at' => $bill->created_at,
                        'amount' => $bill->amount,
                        'amount_bs' => $bill->amount_bs,
                        'products' => $bill->productInvoices->map(function ($productInvoice) {
                            return [
                                'product_id' => $productInvoice->product->id,
                                'product_name' => $productInvoice->product->name,
                                'product_code' => $productInvoice->product->code,
                                'unit_price' => $productInvoice->product->priceUnit,
                                'priceSupplier' => $productInvoice->product->priceSupplier,
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        })->toArray();

        return response()->json([
            'status' => 200,
            'clients' => $response
        ]);
    }
}