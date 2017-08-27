<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use MyCode\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->delete();

        $faker = Faker::create();

        
    	foreach (range(1,7) as $index) {
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

            $company = $faker->company;

	        Customer::create(array(
                'company_id' => 1,
	            'customer_commercial_name' => $company,
	            'customer_legal_name' => $company . $faker->randomElement(array (', Inc.',' Customer',' Co.')),
                'customer_tax_id' => $faker->bothify('###-') . $faker->numberBetween(70, 88) . $faker->bothify('-####'),
                'customer_website' => $faker->url,
                'customer_email' => $email,
                'customer_contact' => $faker->name,
                'customer_phone' => $faker->phoneNumber,
                'customer_cellular' => $faker->phoneNumber,
                'customer_address' => $faker->streetAddress, 
                'customer_location' => 'Monterrey NL, Mexico',                       
                'customer_postcode' => $faker->postcode,
                'customer_latitude' => $faker->latitude(-90, 90),
                'customer_longitude' => $faker->longitude(-180, 180),
	        ));

            $company = $faker->company;

            Customer::create(array(
                'company_id' => 2,
	            'customer_commercial_name' => $company,
	            'customer_legal_name' => $company . $faker->randomElement(array (', Inc.',' Customer',' Co.')),
                'customer_tax_id' => $faker->bothify('###-') . $faker->numberBetween(70, 88) . $faker->bothify('-####'),
                'customer_website' => $faker->url,
                'customer_email' => $email,
                'customer_contact' => $faker->name,
                'customer_phone' => $faker->phoneNumber,
                'customer_cellular' => $faker->phoneNumber,
                'customer_address' => $faker->streetAddress, 
                'customer_location' => 'Monterrey NL, Mexico',                       
                'customer_postcode' => $faker->postcode,
                'customer_latitude' => $faker->latitude(-90, 90),
                'customer_longitude' => $faker->longitude(-180, 180),
	        ));

             $company = $faker->company;

            Customer::create(array(
                'company_id' => 3,
	            'customer_commercial_name' => $company,
	            'customer_legal_name' => $company . $faker->randomElement(array (', Inc.',' Customer',' Co.')),
                'customer_tax_id' => $faker->bothify('###-') . $faker->numberBetween(70, 88) . $faker->bothify('-####'),
                'customer_website' => $faker->url,
                'customer_email' => $email,
                'customer_contact' => $faker->name,
                'customer_phone' => $faker->phoneNumber,
                'customer_cellular' => $faker->phoneNumber,
                'customer_address' => $faker->streetAddress, 
                'customer_location' => 'Monterrey NL, Mexico',                       
                'customer_postcode' => $faker->postcode,
                'customer_latitude' => $faker->latitude(-90, 90),
                'customer_longitude' => $faker->longitude(-180, 180),
	        ));
        }
    }
}
