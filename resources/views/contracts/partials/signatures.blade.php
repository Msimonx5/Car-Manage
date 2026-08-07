<div class="mt-20">

    <table class="border-none">

        <tr>

            <td class="border-none" style="width:33%; text-align:center;">

                <strong>LE LOUEUR</strong>

                <br><br>

                <div style="height:90px;"></div>

                <strong>SOULAMI CAR</strong>

                <br>

                Signature & Cachet

            </td>

            <td class="border-none" style="width:33%; text-align:center;">

                <strong>LE LOCATAIRE</strong>

                <br><br>

                <div style="height:90px;"></div>

                {{ $contract->client->nom }}

                {{ $contract->client->prenom }}

                <br>

                Signature précédée de la mention

                <br>

                <strong>"Lu et approuvé"</strong>

            </td>

            <td class="border-none" style="width:33%; text-align:center;">

                <strong>2ᵉ CONDUCTEUR</strong>

                <br><br>

                @if($contract->secondDriver)

                    <div style="height:90px;"></div>

                    {{ $contract->secondDriver->nom }}

                    {{ $contract->secondDriver->prenom }}

                    <br>

                    Signature

                    <br>

                    <strong>"Lu et approuvé"</strong>

                @else

                    <div style="height:90px;"></div>

                    <em>Aucun</em>

                @endif

            </td>

        </tr>

    </table>

</div>


<div class="mt-20">

    <table>

        <tr>

            <td style="font-size:10px;text-align:center;">

                Fait à Khouribga le

                {{ $contract->created_at->format('d/m/Y') }}

                <br><br>

                Le présent contrat est établi en deux exemplaires originaux,
                un pour le loueur et un pour le locataire.

            </td>

        </tr>

    </table>

</div>