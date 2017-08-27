<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
    }
}
