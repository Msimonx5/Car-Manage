<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

/**
 * Point d'entree unique pour connaitre l'agence (tenant) courante.
 *
 * Les donnees metier sont cloisonnees par agence : chaque utilisateur ne voit
 * que les clients, vehicules, contrats, paiements et infractions de la sienne.
 */
class Tenancy
{
    /**
     * Les requetes doivent-elles etre filtrees sur une agence ?
     *
     * Non filtrees : hors requete authentifiee (console, seeders, migrations)
     * et pour l'administrateur de la plateforme, qui supervise toutes agences.
     */
    public static function restricted(): bool
    {
        $user = Auth::user();

        return $user !== null && ! $user->isPlatformAdmin();
    }

    /**
     * Agence de l'utilisateur connecte.
     *
     * Peut valoir null si le compte n'est rattache a aucune agence : dans ce
     * cas le filtre ne doit rien laisser passer plutot que tout laisser passer.
     */
    public static function currentId(): ?int
    {
        return Auth::user()?->tenant_id;
    }
}
