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

    public function listTable(Request $request){
        $perPage = $request->input('perPage', 10);
        $clients = Client::orderBy('id', 'desc')->paginate($perPage);
        return response()->json(['clients' => $clients]);
    }

    
    public function delete($id){
        Client::where('id', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Cliente eliminado correctamente',
        ]);
    }
    public function update(Request $request, $id){
        $client = Client::find($id);
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->dni = $request->dni;
        $client->address = $request->address;
        $client->save();
        return response()->json([
            'status' => 200,
            'message' => 'Cliente actualizado correctamente',
        ]);
    }
    public function checkEmail($email){
        $client = Client::where('email', $email)->exists();
        if ($client) {
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
    public function checkDni($dni){
        $client = Client::where('dni', $dni)->exists();
        if ($client) {
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
}
