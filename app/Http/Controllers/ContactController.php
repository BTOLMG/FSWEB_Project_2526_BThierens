<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'voornaam'  => 'required|string|max:255',
            'naam'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'onderwerp' => 'required|string|max:255',
            'bericht'   => 'required|string|max:5000',
        ]);

        //TODO hoe send ik een mail?

        return back()->with('status', 'Je bericht is verzonden!');
    }
}
