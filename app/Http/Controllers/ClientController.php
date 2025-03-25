<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function save(Request $request){
        $client = Client::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dni' => $request->dni,
            'address' => $request->address
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Cliente creado correctamente',
        ]);
    }	

    public function list(){
        $clients = Client::get();
        return response()->json([
            'status' => 200,
            'clients' => $clients
        ]);
    }
    public function delete($id){
        Client::where('id', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Cliente eliminado correctamente',
        ]);
    }
}
