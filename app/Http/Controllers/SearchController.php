<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

use \App\Models\Categorie;
use \App\Models\Rubriek;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $zoekterm = $request->get('zoekterm');

        $meta = [
            'zoekterm' => $zoekterm,
        ];

        $actoren = Actor::with(['categorie', 'contactgegevens', 'openingsuren', 'rubrieken'])
            ->when($zoekterm, function ($query) use ($zoekterm) {
                $query->where('publieke_naam', 'like', "%{$zoekterm}%")
                    ->orWhere('aangeboden_diensten', 'like', "%{$zoekterm}%")
                    ->orWhere('gemeente', 'like', "%{$zoekterm}%")
                    ->orWhereHas('rubrieken', function ($q) use ($zoekterm) {
                        $q->where('naam', 'like', "%{$zoekterm}%");
                    })
                    ->orWhereHas('categorie', function ($q) use ($zoekterm) {
                        $q->where('naam', 'like', "%{$zoekterm}%");
                    });
            })
            ->get();

        return view('search', compact('actoren', 'meta'));
    }

    public function keywords()
    {
        $actoren    = Actor::pluck('publieke_naam');
        $rubrieken  = Rubriek::pluck('naam');
        $categorieen = Categorie::pluck('naam');

        $keywords = $actoren->merge($rubrieken)->merge($categorieen)->unique()->values();

        return response()->json($keywords);
    }

    // public function autocomplete(Request $request)
    // {
    //     $query = $request->get('q', '');

    //     $actoren = Actor::where('publieke_naam', 'like', "%{$query}%")
    //         ->limit(10)
    //         ->pluck('publieke_naam');

    //     $rubrieken = Rubriek::where('naam', 'like', "%{$query}%")
    //         ->limit(10)
    //         ->pluck('naam');

    //     $categorieen = Categorie::where('naam', 'like', "%{$query}%")
    //         ->limit(10)
    //         ->pluck('naam');

    //     $suggesties = $actoren->merge($rubrieken)->merge($categorieen)->unique()->values();

    //     return response()->json($suggesties);
    // }
    public function getActorsByIds(Request $request)
    {
        $ids = explode(',', $request->get('ids'));

        $actoren = Actor::with(['categorie', 'contactgegevens', 'openingsuren'])
            ->whereIn('id', $ids)
            ->get()
            ->map(function ($actor) {
                return [
                    'id'          => $actor->id,
                    'naam'        => $actor->publieke_naam,
                    'categorie'   => $actor->categorie->naam,
                    'beschrijving'=> $actor->aangeboden_diensten,
                    'gemeente'    => $actor->gemeente ? $actor->gemeente : '',
                    'postcode'    => $actor->postcode ? $actor->postcode : '',
                    'straatnaam'  => $actor->straatnaam ? $actor->straatnaam : '',
                    'huisnummer'  => $actor->huisnummer ? $actor->huisnummer : '',
                    'busnummer'   => $actor->busnummer ? $actor->busnummer : '',
                    'telefoon'    => $actor->contactgegevens->firstWhere('type', 'telefoonnr')?->waarde,
                    'mail'        => $actor->contactgegevens->firstWhere('type', 'mail')?->waarde,
                    'website'     => $actor->contactgegevens->firstWhere('type', 'online')?->waarde,
                    'openingsuren'=> $actor->openingsuren->map(fn($u) => [
                        'dag'   => $u->dag_van_de_week,
                        'start' => substr($u->startuur, 0, 5),
                        'eind'  => substr($u->einduur, 0, 5),
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
