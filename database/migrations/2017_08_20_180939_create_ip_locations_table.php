<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_locations', function (Blueprint $table) {
            $table->unsignedInteger('ip_from');
            $table->unsignedInteger('ip_to');
            $table->char('country_code', 2);
            $table->string('country_name', 64);
            $table->string('region_name', 128);
            $table->string('city_name', 128);
            $table->double('latitude');
            $table->double('longitude');
            $table->index('ip_from', 'idx_ip_from');
            $table->index('ip_to', 'idx_ip_to');
            $table->index(['ip_from', 'ip_to'], 'idx_ip_from_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_locations');
    }
}
