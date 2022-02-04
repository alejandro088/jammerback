<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Instrument::insert([
            ['name' => 'Guitarra'],
            ['name' => 'Bajo'],
            ['name' => 'Piano'],
            ['name' => 'Violin'],
            ['name' => 'Flauta'],
            ['name' => 'Saxofon'],
            ['name' => 'Trompeta']
        ]);

        // make 10 genres
        \App\Models\Genre::insert([
            ['name' => 'Rock'],
            ['name' => 'Pop'],
            ['name' => 'Metal'],
            ['name' => 'Jazz'],
            ['name' => 'Blues'],
            ['name' => 'Country'],
            ['name' => 'Reggae'],
            ['name' => 'Funk'],
            ['name' => 'Electronica'],
            ['name' => 'Flamenco']

        ]);
        
        // \App\Models\User::factory(4)->create(
        //     [ 'type' => 1 ]
        // );

        // \App\Models\User::factory(4)->create(
        //     [ 'type' => 2 ]
        // );
    }
}
