<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 100);
            $table->string('company_legal_name', 100);
            $table->string('company_tax_id', 30);
            $table->string('company_website', 255);
            $table->string('company_email', 100);
            $table->string('company_contact', 100);
            $table->string('company_phone', 50);
            $table->string('company_cellular', 50);
            $table->string('company_address', 255);
            $table->string('company_location', 255);
            $table->string('company_postcode', 15);
            $table->string('company_latitude', 15);
            $table->string('company_longitude', 15);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('company_name');
            $table->unique('company_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
