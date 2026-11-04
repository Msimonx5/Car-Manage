<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Support\ExcelCsvExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients.
     */
    public function index(Request $request)
    {
        $clients = $this->filteredClients($request)
            ->paginate(15)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function export(Request $request)
    {
        $rows = $this->filteredClients($request)->lazy(500)->map(static fn (Client $client): array => [
            $client->id,
            $client->type,
            $client->nom,
            $client->prenom,
            $client->date_naissance?->format('Y-m-d'),
            $client->lieu_naissance,
            $client->cin,
            $client->nationalite,
            $client->numero_permis,
            $client->numero_passeport,
            $client->telephone,
            $client->email,
            $client->adresse,
            $client->adresse_etranger,
            $client->ville,
            $client->code_postal,
        ]);

        return ExcelCsvExport::download(
            'clients-'.now()->format('Y-m-d').'.csv',
            ['ID', 'Type', 'Nom', 'Prénom', 'Date de naissance', 'Lieu de naissance', 'CIN', 'Nationalité', 'N° permis', 'N° passeport', 'Téléphone', 'E-mail', 'Adresse', 'Adresse à l’étranger', 'Ville', 'Code postal'],
            $rows,
        );
    }

    private function filteredClients(Request $request): Builder
    {
        $query = Client::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('cin', 'like', "%{$q}%")
                    ->orWhere('telephone', 'like', "%{$q}%")
                    ->orWhere('numero_permis', 'like', "%{$q}%")
                    ->orWhereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%{$q}%"]);
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        switch ($request->get('sort', 'latest')) {
            case 'nom':
                $query->orderBy('nom')->orderBy('prenom');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query;
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * Enregistrer un nouveau client.
     */
    public function store(StoreClientRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été créé avec succès.');
    }

    /**
     * Afficher les détails d'un client.
     */
    public function show(Client $client): View
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Mettre à jour un client.
     */
    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été modifié avec succès.');
    }

    /**
     * Supprimer un client.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Le client a été supprimé avec succès.');
    }
}