<?php

use Illuminate\Database\Seeder;
use MyCode\Models\State;


class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->delete();

        State::create(array(
            'country_id'              => 0,
            'state_shortname'         => '',
            'state_name'              => 'Select an option',
        ));

        State::create(array(
            'country_id'              => '2',
            'state_shortname'         => 'TX',
            'state_name'              => 'Texas',
        ));

        State::create(array(
            'country_id'              => '2',
            'state_shortname'         => 'NJ',
            'state_name'              => 'New Jersey',
        ));

        State::create(array(
            'country_id'              => '3',
            'state_shortname'         => 'NL',
            'state_name'              => 'Nuevo León',
        ));

        State::create(array(
            'country_id'              => '3',
            'state_shortname'         => 'DF',
            'state_name'              => 'Distrito Federal',
        ));


    }
}
