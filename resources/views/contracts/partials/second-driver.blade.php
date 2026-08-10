<div class="mt-15">

    <table>

        <tr>

            <td colspan="4" class="section">

                DEUXIÈME CONDUCTEUR

            </td>

        </tr>

        @if($contract->secondDriver)

            <tr>

                <td class="label">
                    Nom
                </td>

                <td>
                    {{ $contract->secondDriver->nom }}
                </td>

                <td class="label">
                    Prénom
                </td>

                <td>
                    {{ $contract->secondDriver->prenom }}
                </td>

            </tr>

            <tr>

                <td class="label">
                    Date de naissance
                </td>

                <td>

                    {{ optional($contract->secondDriver->date_naissance)->format('d/m/Y') }}

                </td>

                <td class="label">
                    Lieu de naissance
                </td>

                <td>

                    {{ $contract->secondDriver->lieu_naissance }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    CIN
                </td>

                <td>

                    {{ $contract->secondDriver->cin }}

                </td>

                <td class="label">
                    Nationalité
                </td>

                <td>

                    {{ $contract->secondDriver->nationalite }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Permis de conduire
                </td>

                <td>

                    {{ $contract->secondDriver->numero_permis }}

                </td>

                <td class="label">
                    Passeport
                </td>

                <td>

                    {{ $contract->secondDriver->numero_passeport ?: '-' }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Téléphone
                </td>

                <td>

                    {{ $contract->secondDriver->telephone }}

                </td>

                <td class="label">
                    Type
                </td>

                <td>

                    Deuxième conducteur

                </td>

            </tr>

            <tr>

                <td class="label">
                    Adresse
                </td>

                <td colspan="3">

                    {{ $contract->secondDriver->adresse }}

                </td>

            </tr>

            <tr>

                <td class="label">
                    Adresse à l'étranger
                </td>

                <td colspan="3">

                    {{ $contract->secondDriver->adresse_etranger ?: '-' }}

                </td>

            </tr>

        @else

            <tr>

                <td colspan="4"
                    style="text-align:center;
                           padding:20px;
                           font-style:italic;
                           color:#666;">

                    Aucun deuxième conducteur renseigné.

                </td>

            </tr>

        @endif

    </table>

</div>