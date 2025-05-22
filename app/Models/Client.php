<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'nom', 'email', 'telephone', 'adresse', 'ville', 'entreprise',
        'user_id', 'employe_id',
    ];

     // L'admin auquel le client est attribué (optionnel)
     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     // Le commercial auquel le client est attribué (optionnel)
     public function employe()
     {
         return $this->belongsTo(Employe::class);
     }
}
