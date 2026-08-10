<div class="mt-15">

    <table>

        <tr>

            <td class="section">

                OBSERVATIONS

            </td>

        </tr>

        <tr>

            <td style="height:70px; vertical-align:top; padding:10px;">

                @if(!empty($contract->observation))

                    {!! nl2br(e($contract->observation)) !!}

                @else

                    Aucune observation.

                @endif

            </td>

        </tr>

    </table>

</div>


<div class="mt-15">

    <table>

        <tr>

            <td class="section">

                CONDITIONS GÉNÉRALES

            </td>

        </tr>

        <tr>

            <td style="padding:10px; font-size:11px; line-height:18px;">

                <ol style="margin:0; padding-left:18px;">

                    <li>
                        Le locataire reconnaît avoir reçu le véhicule en bon état
                        de fonctionnement et s'engage à le restituer dans le même
                        état, sauf usure normale.
                    </li>

                    <li>
                        Toute contravention, amende ou infraction commise durant
                        la période de location reste à la charge du locataire.
                    </li>

                    <li>
                        Le locataire est responsable des dommages causés au
                        véhicule lorsqu'ils ne sont pas couverts par
                        l'assurance.
                    </li>

                    <li>
                        Toute prolongation de location doit être autorisée par
                        écrit par le loueur.
                    </li>

                    <li>
                        Le carburant consommé pendant la location est à la
                        charge du locataire.
                    </li>

                    <li>
                        En cas d'accident, le locataire doit prévenir
                        immédiatement le loueur et les autorités compétentes.
                    </li>

                    <li>
                        Le véhicule ne peut être conduit que par les personnes
                        désignées dans le présent contrat.
                    </li>

                    <li>
                        Le présent contrat est régi par la législation marocaine.
                    </li>

                </ol>

            </td>

        </tr>

    </table>

</div>