<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Afficher la liste des clients.
     */
    public function index(): View
    {
        $clients = Client::latest()->paginate(10);

        return view('clients.index', compact('clients'));
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