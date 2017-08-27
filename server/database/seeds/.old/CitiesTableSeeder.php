<?php

use Illuminate\Database\Seeder;
use MyCode\Models\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();

        City::create(array(
            'state_id'         => 0,
            'city_shortname'   => '',
            'city_name'        => 'Select an option',
        ));

        City::create(array(
            'state_id'         => 2,
            'city_shortname'   => 'HOS',
            'city_name'        => 'Houston',
        ));

         City::create(array(
            'state_id'         => 3,
            'city_shortname'   => 'NY',
            'city_name'        => 'Nueva York',
        ));


        City::create(array(
            'state_id'         => 4,
            'city_shortname'   => 'MTY',
            'city_name'        => 'Monterrey',
        ));

        City::create(array(
            'state_id'         => 4,
            'city_shortname'   => 'APO',
            'city_name'        => 'Apodaca',
        ));

        City::create(array(
            'state_id'         => 5,
            'city_shortname'   => 'DF',
            'city_name'        => 'Distrito Federal',
        ));

    }
}
