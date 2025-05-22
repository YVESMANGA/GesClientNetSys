<?php

namespace App\Http\Controllers;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Client;
class ClientController extends Controller
{
    //
    public function index()
    {
        
        return view('client.index');
    }

    public function list()
    {
        $clients = Client::latest()->get();
        return view('client.clientsp', compact('clients'));
    }

    public function import(Request $request)
    {
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);

    Excel::import(new ClientsImport, $request->file('file'));

    return redirect()->route('clients.clientsp')->with('success', 'Clients importés avec succès.');
}
}
