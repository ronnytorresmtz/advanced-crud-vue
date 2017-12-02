<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use MyCode\Models\Warehouse;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->delete();

        $faker = Faker::create();

    	foreach (range(1,20) as $index) {
            switch ($index) {
                case 1:
                    $email = 'rtorresmtz@hotmail.com';
                    break;
                case 2:
                    $email = 'ronnytorresmtz@gmail.com';
                    break;
                default:
                    $email = $faker->email;
                    break;
            }

	        Warehouse::create(array(
                'customer_id' => 1,
	            'warehouse_name' => $faker->city . ' Warehouse',
                'warehouse_email' => $email,
                'warehouse_contact' => $faker->name,
                'warehouse_phone' => $faker->phoneNumber,
                'warehouse_cellular' => $faker->phoneNumber,
                'warehouse_address' => $faker->streetAddress, 
                'warehouse_location' => 'Monterrey NL, Mexico',                       
                'warehouse_postcode' => $faker->postcode,
                'warehouse_latitude' => $faker->latitude(-90, 90),
                'warehouse_longitude' => $faker->longitude(-180, 180),
	        ));


            Warehouse::create(array(
                'customer_id' => 2,
	            'warehouse_name' => $faker->city . ' Warehouse',
	            'warehouse_email' => $email,
                'warehouse_contact' => $faker->name,
                'warehouse_phone' => $faker->phoneNumber,
                'warehouse_cellular' => $faker->phoneNumber,
                'warehouse_address' => $faker->streetAddress, 
                'warehouse_location' => 'Guadalajara Jal, Mexico',                       
                'warehouse_postcode' => $faker->postcode,
                'warehouse_latitude' => $faker->latitude(-90, 90),
                'warehouse_longitude' => $faker->longitude(-180, 180),
	        ));


            Warehouse::create(array(
                'customer_id' => 3,
	            'warehouse_name' => $faker->city . ' Warehouse',
                'warehouse_email' => $email,
                'warehouse_contact' => $faker->name,
                'warehouse_phone' => $faker->phoneNumber,
                'warehouse_cellular' => $faker->phoneNumber,
                'warehouse_address' => $faker->streetAddress, 
                'warehouse_location' => 'Chihuahua Chih, Mexico',                       
                'warehouse_postcode' => $faker->postcode,
                'warehouse_latitude' => $faker->latitude(-90, 90),
                'warehouse_longitude' => $faker->longitude(-180, 180),
	        ));
        }
    }
}
