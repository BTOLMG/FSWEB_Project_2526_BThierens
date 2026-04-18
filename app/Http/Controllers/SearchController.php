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
}
