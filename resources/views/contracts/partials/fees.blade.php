<div class="mt-15">

    @php

        $status = $contract->statut;

        $statusValue = $status instanceof \App\Enums\ContractStatus
            ? $status->value
            : $status;

        $statuts = [
            'en_attente' => [
                'label' => 'En attente',
                'color' => '#ffc107',
            ],
            'en_cours' => [
                'label' => 'En cours',
                'color' => '#0d6efd',
            ],
            'termine' => [
                'label' => 'Terminé',
                'color' => '#198754',
            ],
            'annule' => [
                'label' => 'Annulé',
                'color' => '#dc3545',
            ],
        ];

        $statusLabel = $statuts[$statusValue]['label'] ?? ucfirst(str_replace('_', ' ', $statusValue));

        $statusColor = $statuts[$statusValue]['color'] ?? '#6c757d';

    @endphp

    <table>

        <tr>

            <td colspan="4" class="section">

                FRAIS & RÈGLEMENT

            </td>

        </tr>

        <tr>

            <td class="label">

                Tarif / jour

            </td>

            <td>

                {{ number_format($contract->tarif_jour, 2, ',', ' ') }} DH

            </td>

            <td class="label">

                Nombre de jours

            </td>

            <td>

                {{ $contract->nombre_jours }}

            </td>

        </tr>

        <tr>

            <td class="label">

                Avance

            </td>

            <td>

                {{ number_format($contract->avance, 2, ',', ' ') }} DH

            </td>

            <td class="label">

                Caution

            </td>

            <td>

                {{ number_format($contract->caution, 2, ',', ' ') }} DH

            </td>

        </tr>

        <tr>

            <td class="label">

                Total H.T.

            </td>

            <td>

                {{ number_format($contract->total_ht, 2, ',', ' ') }} DH

            </td>

            <td class="label">

                TVA (20%)

            </td>

            <td>

                {{ number_format($contract->tva, 2, ',', ' ') }} DH

            </td>

        </tr>

        <tr style="background:#eceff1;font-weight:bold;">

            <td class="label">

                TOTAL T.T.C.

            </td>

            <td>

                {{ number_format($contract->total_ttc, 2, ',', ' ') }} DH

            </td>

            <td class="label">

                Mode de paiement

            </td>

            <td>

                {{ $contract->mode_paiement ?: '-' }}

            </td>

        </tr>

        <tr>

            <td class="label">

                Statut

            </td>

            <td colspan="3">

                <span style="
                    display:inline-block;
                    padding:6px 14px;
                    border-radius:4px;
                    background:{{ $statusColor }};
                    color:white;
                    font-weight:bold;
                ">

                    {{ $statusLabel }}

                </span>

            </td>

        </tr>

    </table>

</div>