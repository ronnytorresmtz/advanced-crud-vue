<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('customer_name', 100);
            $table->string('customer_legal_name', 100);
            $table->string('customer_tax_id', 30);
            $table->string('customer_website', 255);
            $table->string('customer_email', 100);
            $table->string('customer_contact', 100);
            $table->string('customer_phone', 50);
            $table->string('customer_cellular', 50);
            $table->string('customer_address', 255);
            $table->string('customer_location', 255);
            $table->string('customer_postcode', 15);
            $table->string('customer_latitude', 15);
            $table->string('customer_longitude', 15);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(array('company_id', 'customer_name'));
            $table->unique(array('company_id','customer_email'));
            // $table->index('company_id','customer_name', 'customer_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    } 
}
