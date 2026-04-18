<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Categorie;
use App\Models\Contactgegeven;
use App\Models\Openingsuur;
use App\Models\Rubriek;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Categorieën ──────────────────────────────────────────────────────
        $vrij  = Categorie::create(['naam' => 'Vrije tijd']);
        $gezond = Categorie::create(['naam' => 'Gezondheid']);

        // ── Rubrieken ─────────────────────────────────────────────────────────
        Rubriek::insert([
            ['id' => '11',       'naam' => 'JONGEREN',                    'level' => 1],
            ['id' => '11.02',    'naam' => 'Jeugdwelzijnswerk',           'level' => 2],
            ['id' => '11.02.04', 'naam' => 'Vrijetijdsinitiatieven',      'level' => 3],
            ['id' => '02',       'naam' => 'LICHAMELIJKE GEZONDHEIDSZORG','level' => 1],
            ['id' => '02.02',    'naam' => 'Dringende medische hulpverlening', 'level' => 2],
            ['id' => '02.02.04', 'naam' => 'Tabakologen',                 'level' => 3],
        ]);

        // ── Admin gebruiker ───────────────────────────────────────────────────
        User::create([
            'rol'        => 'administrator',
            'email'      => 'admin@jongerenkaart.be',
            'wachtwoord' => Hash::make('password'),
        ]);

        // ── Actoren ───────────────────────────────────────────────────────────
        $actoren = [
            [
                'id'                => 1,
                'publieke_naam'     => 'Groep INTRO - Regio Limburg - Vestiging Sint-Truiden',
                'categorie_id'      => $vrij->id,
                'betaalwijze'       => null,
                'leeftijdscategorie'=> 'jongvolwassenen',
                'leeftijd_min'      => 12,
                'leeftijd_max'      => 25,
                'straatnaam'        => 'Luikersteenweg',
                'huisnummer'        => '7',
                'gemeente'          => 'Sint-Truiden',
                'postcode'          => '3800',
                'lat'               => 50.81238628,
                'lon'               => 5.18875002,
                'aangeboden_diensten' => 'Vormingen rond vrije tijd, arbeid en onderwijs',
                'last_updated'      => '2025-01-01',
            ],
            [
                'id'                => 2,
                'publieke_naam'     => 'Gigos - Jeugdwelzijnswerk Genk',
                'categorie_id'      => $vrij->id,
                'betaalwijze'       => null,
                'leeftijdscategorie'=> 'jongeren',
                'leeftijd_min'      => 12,
                'leeftijd_max'      => 25,
                'straatnaam'        => 'Bijlkestraat',
                'huisnummer'        => '12',
                'gemeente'          => 'Genk',
                'postcode'          => '3600',
                'lat'               => 50.93206384,
                'lon'               => 5.53125753,
                'aangeboden_diensten' => 'Jeugdwerking en ateliers',
                'last_updated'      => '2025-01-01',
            ],
            [
                'id'                => 3,
                'publieke_naam'     => 'PROFO vzw - Hasselt',
                'categorie_id'      => $vrij->id,
                'betaalwijze'       => null,
                'leeftijdscategorie'=> 'jongeren',
                'leeftijd_min'      => 12,
                'leeftijd_max'      => 25,
                'straatnaam'        => 'Koningin Astridlaan',
                'huisnummer'        => '33',
                'gemeente'          => 'Hasselt',
                'postcode'          => '3500',
                'lat'               => 50.93161222,
                'lon'               => 5.33152526,
                'aangeboden_diensten' => 'Arbeidsgerichte trajecten voor jongeren',
                'last_updated'      => '2025-01-01',
            ],
            [
                'id'                => 4,
                'publieke_naam'     => 'Jeugdhuis Aurora',
                'categorie_id'      => $vrij->id,
                'betaalwijze'       => null,
                'leeftijdscategorie'=> 'jongeren',
                'leeftijd_min'      => 12,
                'leeftijd_max'      => 25,
                'straatnaam'        => 'Ervaert',
                'huisnummer'        => '1d',
                'gemeente'          => 'Tongeren-Borgloon',
                'postcode'          => '3840',
                'lat'               => 50.8104278,
                'lon'               => 5.3421985,
                'aangeboden_diensten' => 'Ontmoetingsplek voor jongeren',
                'last_updated'      => '2025-01-01',
            ],
            [
                'id'                => 5,
                'publieke_naam'     => 'Paramedisch Centrum voor Obesitas & Diabetes',
                'categorie_id'      => $gezond->id,
                'betaalwijze'       => 'sociaal tarief',
                'leeftijdscategorie'=> 'volwassenen',
                'leeftijd_min'      => 18,
                'leeftijd_max'      => 99,
                'straatnaam'        => 'Langenberg',
                'huisnummer'        => '49',
                'gemeente'          => 'Diest',
                'postcode'          => '3294',
                'lat'               => 50.99892039,
                'lon'               => 5.03049957,
                'aangeboden_diensten' => 'Behandeling obesitas en diabetes',
                'last_updated'      => '2025-01-01',
            ],
        ];

        foreach ($actoren as $data) {
            Actor::create($data);
        }

        // ── Actor–Rubriek koppelingen ─────────────────────────────────────────
        Actor::find(1)->rubrieken()->attach(['11', '11.02']);
        Actor::find(2)->rubrieken()->attach(['11', '11.02']);
        Actor::find(3)->rubrieken()->attach(['11', '11.02']);
        Actor::find(4)->rubrieken()->attach(['11', '11.02']);
        Actor::find(5)->rubrieken()->attach(['02', '02.02', '02.02.04']);

        // ── Contactgegevens ───────────────────────────────────────────────────
        $contacten = [
            ['actor_id' => 1, 'type' => 'telefoonnr', 'waarde' => '0473523900'],
            ['actor_id' => 1, 'type' => 'mail',       'waarde' => 'maryam.jamshid@groepintro.be'],
            ['actor_id' => 2, 'type' => 'telefoonnr', 'waarde' => '089258191'],
            ['actor_id' => 2, 'type' => 'mail',       'waarde' => 'info@gigos.be'],
            ['actor_id' => 3, 'type' => 'telefoonnr', 'waarde' => '0488663796'],
            ['actor_id' => 3, 'type' => 'mail',       'waarde' => 'karima.lakdim@profo.be'],
            ['actor_id' => 4, 'type' => 'telefoonnr', 'waarde' => '0479332084'],
            ['actor_id' => 4, 'type' => 'mail',       'waarde' => 'bert.cordens@telenet.be'],
            ['actor_id' => 5, 'type' => 'telefoonnr', 'waarde' => '013328731'],
            ['actor_id' => 5, 'type' => 'mail',       'waarde' => 'pascale@dietistindiest.be'],
            ['actor_id' => 5, 'type' => 'online',     'waarde' => 'https://www.dietistindiest.be'],
        ];
        Contactgegeven::insert($contacten);

        // ── Openingsuren ──────────────────────────────────────────────────────
        $uren = [
            ['actor_id' => 1, 'dag_van_de_week' => 'maandag',  'startuur' => '08:30', 'einduur' => '16:00', 'type' => 'open'],
            ['actor_id' => 1, 'dag_van_de_week' => 'dinsdag',  'startuur' => '08:30', 'einduur' => '16:00', 'type' => 'open'],
            ['actor_id' => 2, 'dag_van_de_week' => 'maandag',  'startuur' => '09:00', 'einduur' => '17:00', 'type' => 'open'],
            ['actor_id' => 2, 'dag_van_de_week' => 'dinsdag',  'startuur' => '09:00', 'einduur' => '17:00', 'type' => 'open'],
            ['actor_id' => 3, 'dag_van_de_week' => 'maandag',  'startuur' => '08:30', 'einduur' => '17:00', 'type' => 'open'],
            ['actor_id' => 3, 'dag_van_de_week' => 'dinsdag',  'startuur' => '08:30', 'einduur' => '17:00', 'type' => 'open'],
            ['actor_id' => 4, 'dag_van_de_week' => 'woensdag', 'startuur' => '15:00', 'einduur' => '01:00', 'type' => 'open'],
            ['actor_id' => 4, 'dag_van_de_week' => 'vrijdag',  'startuur' => '15:00', 'einduur' => '03:00', 'type' => 'open'],
            ['actor_id' => 5, 'dag_van_de_week' => 'zaterdag', 'startuur' => '09:00', 'einduur' => '13:00', 'type' => 'op afspraak'],
        ];
        Openingsuur::insert($uren);
    }
}
