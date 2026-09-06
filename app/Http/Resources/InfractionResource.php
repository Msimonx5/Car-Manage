<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            
            // Client Data
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'cin' => $this->cin,
            'numero_permis' => $this->numero_permis,
            'adresse' => $this->adresse,
            'ville' => $this->ville,
            'code_postal' => $this->code_postal,
            'telephone' => $this->telephone,
            'email' => $this->email,

            // Vehicle Data
            'immatriculation' => $this->immatriculation,
            'marque' => $this->marque,
            'modele' => $this->modele,

            // Contract Data
            'numero_contrat' => $this->numero_contrat,
            'date_depart' => $this->date_depart,
            'heure_depart' => $this->heure_depart,
            'date_retour' => $this->date_retour,
            'heure_retour' => $this->heure_retour,
            
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}