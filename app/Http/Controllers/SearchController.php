<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Rubriek;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $zoekterm          = $request->get('zoekterm');
        $selectedGemeentes = $request->get('gemeentes', []);
        $selectedRubrieken = $request->get('rubrieken', []);

        $meta = [
            'zoekterm'          => $zoekterm,
            'selectedGemeentes' => $selectedGemeentes,
            'selectedRubrieken' => $selectedRubrieken,
        ];

        $basisQuery = Actor::with(['categorie', 'contactgegevens', 'openingsuren', 'rubrieken'])
            ->when($zoekterm, function ($query) use ($zoekterm) {
                $query->where(function ($subQuery) use ($zoekterm) {
                    $subQuery
                        ->where('publieke_naam', 'like', "%{$zoekterm}%")
                        ->orWhere('aangeboden_diensten', 'like', "%{$zoekterm}%")
                        ->orWhere('gemeente', 'like', "%{$zoekterm}%")
                        ->orWhereHas('rubrieken', fn($rubriekQuery) => $rubriekQuery->where('naam', 'like', "%{$zoekterm}%"))
                        ->orWhereHas('categorie',  fn($categorieQuery) => $categorieQuery->where('naam', 'like', "%{$zoekterm}%"));
                });
            });

        $alleZoektermActoren = $basisQuery->get();


        $gefilterdeActoren = $basisQuery
            ->when($selectedGemeentes, function ($query) use ($selectedGemeentes) {
                $query->where(function ($subQuery) use ($selectedGemeentes) {
                    foreach ($selectedGemeentes as $gemeenteLabel) {
                        $delen    = explode(' ', $gemeenteLabel, 2);
                        $postcode = $delen[0] ?? '';
                        $gemeente = $delen[1] ?? '';

                        $subQuery->orWhere(function ($gemeenteQuery) use ($postcode, $gemeente) {
                            $gemeenteQuery
                                ->where('postcode', $postcode)
                                ->where('gemeente', $gemeente);
                        });
                    }
                });
            })
            ->when($selectedRubrieken, function ($query) use ($selectedRubrieken) {
                $query->whereHas('rubrieken', fn($rubriekQuery) =>
                    $rubriekQuery->whereIn('naam', $selectedRubrieken)
                );
            })
            ->get();


        $gemeenteLabel = fn($actor) => trim(($actor->postcode ?? '') . ' ' . $actor->gemeente);

        $tellingPerGemeente = $gefilterdeActoren
            ->filter(fn($actor) => filled($actor->gemeente))
            ->countBy($gemeenteLabel);

        $alleGemeentes = $alleZoektermActoren
            ->filter(fn($actor) => filled($actor->gemeente))
            ->map($gemeenteLabel)
            ->unique()
            ->sort();

        $gemeenteAccordionItems = $alleGemeentes
            ->mapWithKeys(fn($label) => [$label => $tellingPerGemeente->get($label, 0)]);


        $tellingPerRubriek = $gefilterdeActoren
            ->flatMap(fn($actor) => $actor->rubrieken
            ->pluck('naam'))
            ->countBy();

        $alleRubrieken = $alleZoektermActoren
            ->flatMap(fn($actor) => $actor->rubrieken
            ->pluck('naam'))
            ->unique();

        $rubriekAccordionItems = $alleRubrieken
            ->mapWithKeys(fn($naam) => [$naam => $tellingPerRubriek->get($naam, 0)])
            ->sortByDesc(fn($telling) => $telling);


        return view('search', compact(
            'meta',
            'gefilterdeActoren',
            'gemeenteAccordionItems',
            'rubriekAccordionItems',
        ));
    }

    public function keywords()
    {
        $actoren        = Actor::pluck('publieke_naam');
        $rubrieken      = Rubriek::pluck('naam');
        $categorieen    = Categorie::pluck('naam');
        $keywords       = $actoren->merge($rubrieken)->merge($categorieen)->unique()->values();

        return response()->json($keywords);
    }

    public function getActorsByIds(Request $request)
    {
        $ids = explode(',', $request->get('ids'));

        $actoren = Actor::with(['categorie', 'contactgegevens', 'openingsuren'])
            ->whereIn('id', $ids)
            ->get()
            ->map(function ($actor) {
                return [
                    'id'            => $actor->id,
                    'naam'          => $actor->publieke_naam,
                    'categorie'     => $actor->categorie->naam,
                    'beschrijving'  => $actor->aangeboden_diensten,
                    'gemeente'      => $actor->gemeente ?? '',
                    'postcode'      => $actor->postcode  ?? '',
                    'straatnaam'    => $actor->straatnaam ?? '',
                    'huisnummer'    => $actor->huisnummer ?? '',
                    'busnummer'     => $actor->busnummer  ?? '',
                    'telefoon'      => $actor->contactgegevens->firstWhere('type', 'telefoonnr')?->waarde,
                    'mail'          => $actor->contactgegevens->firstWhere('type', 'mail')?->waarde,
                    'website'       => $actor->contactgegevens->firstWhere('type', 'online')?->waarde,
                    'openingsuren'  => $actor->openingsuren->map(fn($u) => [
                        'dag'       => $u->dag_van_de_week,
                        'start'     => substr($u->startuur, 0, 5),
                        'eind'      => substr($u->einduur, 0, 5),
                    ]),
                ];
            });

        return response()->json($actoren);
    }

    public function getAll($id)
    {
        $actor = Actor::with(['categorie', 'contactgegevens', 'openingsuren', 'rubrieken'])
            ->where('id', $id)
            ->firstOrFail();

        return view('details', compact('actor'));
    }
}
