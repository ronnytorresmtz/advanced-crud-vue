<?php

use Illuminate\Database\Seeder;
use MyCode\Models\Location;
use Faker\Factory as Faker;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->delete();
        
        $faker = Faker::create();

        foreach (range(1,3000) as $index) {
             Location::create(array(
                'location_name' => $faker->city . ' ' . $faker->state . ', ' . $faker->country,
            ));
        }   
        
        // Location::create(array(
        //     'location_name' => 'Apodaca NL, México',
        // ));
        // Location::create(array(
        //     'location_name' => 'Guadalupe NL, México',
        // ));
        // Location::create(array(
        //     'location_name' => 'Ciudad de Mexico CX, México',
        // ));
        // Location::create(array(
        //     'location_name' => 'Guadalajara JAL, México',
        // ));
        // Location::create(array(
        //     'location_name' => 'San Nicolas NL, México',
        // ));

    }
}
