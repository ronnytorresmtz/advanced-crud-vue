<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('warehouse_name', 100);
            $table->string('warehouse_email', 100);
            $table->string('warehouse_contact', 100);
            $table->string('warehouse_phone', 50);
            $table->string('warehouse_cellular', 50);
            $table->string('warehouse_address', 255);
            $table->string('warehouse_location', 255);
            $table->string('warehouse_postcode', 15);
            $table->string('warehouse_latitude', 15);
            $table->string('warehouse_longitude', 15);
            $table->softDeletes();
            $table->timestamps();

            $table->index('customer_id', 'warehouse_name');
            $table->index('customer_id', 'warehouse_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    } 
}
