<div class="mt-15">

    <table>

        <tr>

            <td colspan="4" class="section">

                CLIENT PRINCIPAL

            </td>

        </tr>

        <tr>

            <td class="label">
                Nom
            </td>

            <td class="value">
                {{ $contract->client->nom }}
            </td>

            <td class="label">
                Prénom
            </td>

            <td class="value">
                {{ $contract->client->prenom }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Date de naissance
            </td>

            <td>
                {{ optional($contract->client->date_naissance)->format('d/m/Y') }}
            </td>

            <td class="label">
                Lieu de naissance
            </td>

            <td>
                {{ $contract->client->lieu_naissance }}
            </td>

        </tr>

        <tr>

            <td class="label">
                CIN
            </td>

            <td>
                {{ $contract->client->cin }}
            </td>

            <td class="label">
                Nationalité
            </td>

            <td>
                {{ $contract->client->nationalite }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Permis de conduire
            </td>

            <td>
                {{ $contract->client->numero_permis }}
            </td>

            <td class="label">
                Passeport
            </td>

            <td>
                {{ $contract->client->numero_passeport ?? '-' }}
            </td>

        </tr>

        <tr>

            <td class="label">
                Téléphone
            </td>

            <td>
                {{ $contract->client->telephone }}
            </td>

            <td class="label">
                Type Client
            </td>

            <td>

                @if($contract->client->type == 'principal')

                    Principal

                @else

                    Secondaire

                @endif

            </td>

        </tr>

        <tr>

            <td class="label">
                Adresse
            </td>

            <td colspan="3">

                {{ $contract->client->adresse }}

            </td>

        </tr>

        <tr>

            <td class="label">
                Adresse à l'étranger
            </td>

            <td colspan="3">

                {{ $contract->client->adresse_etranger ?: '-' }}

            </td>

        </tr>

    </table>

</div>