<?php

namespace App\Http\Controllers;
use App\Models\Actor;

class KaartController extends Controller
{
    public function getActoren()
    {
        $actoren = Actor::with(['categorie', 'contactgegevens'])
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get()
            ->map(function ($actor) {
                $telefoon = $actor->contactgegevens->firstWhere('type', 'telefoonnr')?->waarde;
                $mail     = $actor->contactgegevens->firstWhere('type', 'mail')?->waarde;
                $website  = $actor->contactgegevens->firstWhere('type', 'online')?->waarde;

                return [
                    'id'            => $actor->id,
                    'naam'          => $actor->publieke_naam,
                    'categorie'     => $actor->categorie->naam ?? null,
                    'beschrijving'  => $actor->aangeboden_diensten,
                    'straatnaam'    => $actor->straatnaam,
                    'huisnummer'    => $actor->huisnummer,
                    'busnummer'     => $actor->busnummer,
                    'postcode'      => $actor->postcode,
                    'gemeente'      => $actor->gemeente,
                    'lat'           => (float) $actor->lat,
                    'lon'           => (float) $actor->lon,
                    'telefoon'      => $telefoon,
                    'mail'          => $mail,
                    'website'       => $website,
                    'openingsuren'  => $actor->openingsuren->map(fn($u) => [
                        'dag'       => $u->dag_van_de_week,
                        'start'     => substr($u->startuur, 0, 5),
                        'eind'      => substr($u->einduur, 0, 5),
                    ]),
                ];
            });

        return response()->json($actoren);
    }
}
?>
