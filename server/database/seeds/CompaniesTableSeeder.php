<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use MyCode\Models\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->delete();

        $faker = Faker::create();

    	foreach (range(1,3) as $index) {
    
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

	        Company::create(array(

	            'company_name' => $company . $index,
	            'company_legal_name' => $company . $faker->randomElement(array (', Inc.',' Company',' Co.')),
                'company_tax_id' => $faker->bothify('###-') . $faker->numberBetween(70, 88) . $faker->bothify('-####'),
                'company_website' => $faker->url,
                'company_email' => $index . $email ,
                'company_contact' => $faker->name,
                'company_phone' => $faker->phoneNumber,
                'company_cellular' => $faker->phoneNumber,
                'company_address' => $faker->streetAddress, 
                'company_location' => 'Monterrey NL, Mexico',                       
                'company_postcode' => $faker->postcode,
                'company_latitude' => $faker->latitude(-90, 90),
                'company_longitude' => $faker->longitude(-180, 180),

            ));
            
        }

    }

}
