<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Contract;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Consultation et modification du rattachement des comptes aux agences.
 *
 * Sans argument, affiche qui voit quoi. Avec un email et un nom d'agence,
 * deplace le compte vers cette agence, en la creant si besoin.
 */
class AssignTenantCommand extends Command
{
    protected $signature = 'tenant:assign
                            {email? : Email du compte a deplacer}
                            {agence? : Nom de l\'agence de destination}';

    protected $description = "Affiche ou modifie le rattachement des comptes aux agences";

    public function handle(): int
    {
        $email = $this->argument('email');
        $agence = $this->argument('agence');

        if ($email === null || $agence === null) {
            $this->afficherEtat();

            if ($email !== null || $agence !== null) {
                $this->newLine();
                $this->warn('Indiquez a la fois un email et un nom d\'agence pour deplacer un compte.');

                return self::INVALID;
            }

            return self::SUCCESS;
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Aucun compte avec l'email {$email}.");

            return self::FAILURE;
        }

        $tenant = Tenant::firstOrCreate(
            ['slug' => Str::slug($agence)],
            ['name' => $agence]
        );

        $ancienne = $user->tenant?->name ?? 'aucune agence';

        $user->forceFill(['tenant_id' => $tenant->id])->save();

        $this->info("{$user->email} : {$ancienne} -> {$tenant->name}");
        $this->line("Les donnees ne suivent pas le compte : elles restent rattachees a leur agence d'origine.");
        $this->newLine();

        $this->afficherEtat();

        return self::SUCCESS;
    }

    private function afficherEtat(): void
    {
        $this->table(
            ['Agence', 'Clients', 'Vehicules', 'Contrats'],
            Tenant::orderBy('id')->get()->map(fn (Tenant $tenant) => [
                "{$tenant->name} (#{$tenant->id})",
                Client::withoutGlobalScopes()->where('tenant_id', $tenant->id)->count(),
                Vehicle::withoutGlobalScopes()->where('tenant_id', $tenant->id)->count(),
                Contract::withoutGlobalScopes()->where('tenant_id', $tenant->id)->count(),
            ])
        );

        $this->table(
            ['Compte', 'Email', 'Agence'],
            User::with('tenant')->orderBy('id')->get()->map(fn (User $user) => [
                $user->name,
                $user->email,
                $user->isPlatformAdmin()
                    ? 'toutes les agences'
                    : ($user->tenant?->name ?? 'aucune — ne voit rien'),
            ])
        );
    }
}
