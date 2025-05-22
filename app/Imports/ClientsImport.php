<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            //
            'nom'       => $row[0],
            'email'     => $row[1],
            'telephone' => $row[2],
            'adresse'   => $row[3],
            'ville'     => $row[4],
            'entreprise'=> $row[5],
        ]);
    }
}
