<?php

use Illuminate\Database\Seeder;
use MyCode\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->delete();

        Country::create(array(
            'country_shortname'         => '',
            'country_name'              => 'Select an option',
        ));

        Country::create(array(
            'country_shortname'         => 'USA',
            'country_name'              => 'United States',
        ));

        Country::create(array(
            'country_shortname'         => 'Mex',
            'country_name'              => 'México',
        ));

         Country::create(array(
            'country_shortname'         => 'Can',
            'country_name'              => 'Canada',
        ));
    }
}
