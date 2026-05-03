<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->rol !== 'administrator') {
            return redirect('/')->with('error', 'Geen toegang.');
        }
        return view('admin');
    }

    public function store(Request $request)
    {
        if (Auth::user()->rol !== 'administrator') {
            abort(403);
        }

        $validated = $request->validate([
            'email'         => 'required|email|unique:gebruiker,email',
            'password'      => 'required|min:8',
        ]);

        User::create([
            'email'         => $validated['email'],
            'wachtwoord'    => Hash::make($validated['password']),
            'rol'           => 'actorbeheerder',
        ]);

        return redirect()->back()->with('status', 'Nieuwe organisatie succesvol aangemaakt!');
    }

    public function overzicht()
    {
        if (Auth::user()->rol !== 'administrator') {
            return redirect('/')->with('error', 'Geen toegang.');
        }

        $actoren = Actor::with(['categorie', 'contactpersoon'])
            ->orderBy('publieke_naam')
            ->get()
            ->map(fn($a) => [
                'id'        => $a->id,
                'naam'      => $a->publieke_naam,
                'categorie' => $a->categorie->naam ?? '-',
                'gemeente'  => $a->gemeente ?? '-',
                'isVisible' => $a->isVisible,
                'beheerder' => $a->contactpersoon?->email ?? null,
            ]);

        $users = User::where('rol', '!=', 'administrator')
            ->orderBy('email')
            ->get()
            ->map(fn($u) => [
                'id'        => $u->id,
                'email'     => $u->email,
                'rol'       => $u->rol,
                'actoren'   => $u->actoren->pluck('publieke_naam')->join(', ') ?: '-',
            ]);

        return view('admin-overzicht', compact('actoren', 'users'));
    }

    public function destroyActor(Actor $actor)
    {
        if (Auth::user()->rol !== 'administrator') {
            abort(403);
        }
        $actor->delete();
        return back()->with('status', "Actor \"{$actor->publieke_naam}\" verwijderd.");
    }

    public function destroyUser(User $user)
    {
        if (Auth::user()->rol !== 'administrator') {
            abort(403);
        }
        if ($user->rol === 'administrator') {
            abort(403, 'Administrators kunnen niet verwijderd worden via deze pagina.');
        }

        $actoren = $user->actoren;

        foreach ($actoren as $actor) {
            $actor->delete();
        }

        $user->delete();

        return back()->with('status', "Gebruiker \"{$user->email}\" verwijderd. En alle actoren van deze organisatie");
    }
}
