<div class="mt-15">

    <table>

        <tr>

            <td colspan="4" class="section">

                VÉHICULE

            </td>

        </tr>

        <tr>

            <td class="label">
                Marque
            </td>

            <td>
                {{ $contract->vehicle->marque }}
            </td>

            <td class="label">
                Modèle
            </td>

            <td>
                {{ $contract->vehicle->modele }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Immatriculation
            </td>

            <td>
                {{ $contract->vehicle->immatriculation }}
            </td>

            <td class="label">
                Année
            </td>

            <td>
                {{ $contract->vehicle->annee }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Couleur
            </td>

            <td>
                {{ $contract->vehicle->couleur }}
            </td>

            <td class="label">
                Carburant
            </td>

            <td>
                {{ $contract->vehicle->carburant }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Date départ
            </td>

            <td>

                {{ $contract->date_depart->format('d/m/Y') }}

                à

                {{ $contract->heure_depart }}

            </td>

            <td class="label">
                Date retour
            </td>

            <td>

                {{ $contract->date_retour->format('d/m/Y') }}

                à

                {{ $contract->heure_retour }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Kilométrage départ
            </td>

            <td>

                {{ number_format($contract->km_depart,0,',',' ') }} Km

            </td>

            <td class="label">
                Kilométrage retour
            </td>

            <td>

                {{ $contract->km_retour
                    ? number_format($contract->km_retour,0,',',' ').' Km'
                    : '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Kilométrage actuel
            </td>

            <td>

                {{ number_format($contract->vehicle->kilometrage_actuel,0,',',' ') }}
                Km

            </td>

            <td class="label">
                État
            </td>

            <td>

                {{ ucfirst($contract->vehicle->etat) }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Dernière vidange
            </td>

            <td>

                {{ number_format($contract->vehicle->kilometrage_derniere_vidange,0,',',' ') }}
                Km

            </td>

            <td class="label">
                Prochaine vidange
            </td>

            <td>

                {{ number_format($contract->vehicle->kilometrage_prochaine_vidange,0,',',' ') }}
                Km

            </td>

        </tr>

        <tr>

            <td class="label">
                Statut vidange
            </td>

            <td colspan="3">

                @if($contract->vehicle->vidange_a_faire)

                    <strong style="color:red;">
                        VIDANGE À EFFECTUER
                    </strong>

                @else

                    <strong style="color:green;">
                        VIDANGE À JOUR
                    </strong>

                @endif

            </td>

        </tr>

    </table>

</div>