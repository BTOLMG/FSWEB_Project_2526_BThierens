<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Rubriek;
use App\Models\Contactgegeven;
use App\Models\Openingsuur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ActorBeheerController extends Controller
{
    public function index()
    {
        if (Auth::user()->rol !== 'actorbeheerder') {
            return redirect('/')->with('error', 'Geen toegang.');
        }

        $user = Auth::user();
        $actoren = $user->actoren()
            ->with('categorie')
            ->orderBy('publieke_naam')
            ->get();

        $categorieen = Categorie::all();
        return view('account-overzicht', compact('actoren', 'user', 'categorieen'));
    }

    public function edit(Actor $actor)
    {
        $this->authorizeActor($actor);

        $actor->load(['contactgegevens', 'openingsuren', 'rubrieken']);

        $openingsuren  = $actor->openingsuren->keyBy('dag_van_de_week');
        $alleRubrieken = Rubriek::orderBy('level')->orderBy('naam')->get();
        $gekoppeldeIds = $actor->rubrieken->pluck('id')->toArray();
        $user          = Auth::user();

        return view('account', compact('actor', 'user', 'openingsuren', 'alleRubrieken', 'gekoppeldeIds'));
    }

    public function update(Request $request, Actor $actor)
    {
        $this->authorizeActor($actor);

        $request->validate([
            'publieke_naam'         => 'required|string|max:255',
            'leeftijd_min'          => 'nullable|integer|min:0|max:99|lt:leeftijd_max',
            'leeftijd_max'          => 'nullable|integer|min:0|max:99|gt:leeftijd_min',
            'lat'                   => 'nullable|numeric',
            'lon'                   => 'nullable|numeric',
            'password'              => 'nullable|min:8|confirmed',
            'openingsuren.*.van'    => 'required_with:openingsuren.*.open',
            'openingsuren.*.tot'    => 'required_with:openingsuren.*.open',
        ]);

        $actor->update([
            'publieke_naam'         => $request->publieke_naam,
            'betaalwijze'           => $request->betaalwijze,
            'leeftijdscategorie'    => $request->leeftijdscategorie,
            'leeftijd_min'          => $request->leeftijd_min,
            'leeftijd_max'          => $request->leeftijd_max,
            'straatnaam'            => $request->straatnaam,
            'huisnummer'            => $request->huisnummer,
            'busnummer'             => $request->busnummer,
            'gemeente'              => $request->gemeente,
            'postcode'              => $request->postcode,
            'lat'                   => $request->lat,
            'lon'                   => $request->lon,
            'aangeboden_diensten'   => $request->aangeboden_diensten,
            'opmerkingen'           => $request->opmerkingen,
            'isVisible'             => $request->boolean('isVisible'),
            'last_updated'          => now(),
        ]);

        foreach (['telefoonnr', 'mail', 'online'] as $type) {
            $waarde = $request->input(
                $type === 'online' ? 'website' : ($type === 'mail' ? 'mail' : 'telefoonnr')
            );
            $contactgegevens = $actor->contactgegevens->where('type', $type)->first();
            if ($waarde) {
                if ($contactgegevens) {
                    $contactgegevens->update(['waarde' => $waarde]);
                } else {
                    Contactgegeven::create(['actor_id' => $actor->id, 'type' => $type, 'waarde' => $waarde]);
                }
            } elseif ($contactgegevens) {
                $contactgegevens->delete();
            }
        }

        $actor->rubrieken()->sync($request->input('rubrieken', []));

        $dagen = ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag'];
        foreach ($dagen as $dag) {
            $data = $request->input("openingsuren.$dag");
            $bestaand = $actor->openingsuren->where('dag_van_de_week', $dag)->first();

            if (!empty($data['open'])) {
                if ($data['van'] >= $data['tot']) {
                    return back()->withErrors([
                        "openingsuren.$dag" => "Eindtijd moet later zijn dan begintijd ($dag)."
                    ]);
                }

                $payload = [
                    'actor_id'        => $actor->id,
                    'dag_van_de_week' => $dag,
                    'startuur'        => $data['van'] ?? null,
                    'einduur'         => $data['tot'] ?? null,
                    'type'            => 'open',
                ];
                if ($bestaand) {
                    $bestaand->update($payload);
                } else {
                    Openingsuur::create($payload);
                }
            } elseif ($bestaand) {
                $bestaand->delete();
            }
        }

        if ($request->filled('password')) {
            Auth::user()->update(['wachtwoord' => Hash::make($request->password)]);
        }

        return redirect()->route('account.edit', $actor->id)
            ->with('status', 'Wijzigingen succesvol opgeslagen!');
    }

    private function authorizeActor(Actor $actor): void
    {
        if (Auth::user()->rol !== 'actorbeheerder') {
            abort(403, 'Je hebt geen toegang.');
        }

        if ($actor->contactpersoon_gebruiker_id !== Auth::id()) {
            abort(403, 'Je hebt geen toegang tot deze actor.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'publieke_naam' => 'required|string|max:255',
            'categorie_id'  => 'required|exists:categorie,id',
        ]);

        Actor::create([
            'publieke_naam'               => $request->publieke_naam,
            'categorie_id'                => $request->categorie_id,
            'contactpersoon_gebruiker_id' => Auth::id(),
        ]);

        return redirect()->route('account.index')
            ->with('status', 'Actor succesvol aangemaakt!');
    }

    public function destroy(Actor $actor)
    {
        $this->authorizeActor($actor);

        $actor->delete();

        return redirect()->route('account.index')
            ->with('status', 'Actor succesvol verwijderd!');
    }
}
