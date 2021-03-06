<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogRepairUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_repair_update', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('repair_id');
            $table->string('user_id')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->string('update_location_id')->nullable();
            $table->string('update_user_id')->nullable();
            $table->string('update_user_name')->nullable();
            $table->string('update_user_mobile')->nullable();
            $table->string('update_user_description')->nullable();
            $table->timestamps();

            $table->index('repair_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_repair_update');
    }
}
