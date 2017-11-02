<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('introduction', 128)->nullable();
            $table->unsignedInteger('auto_hours')->default(0);
            $table->unsignedInteger('auto_stars')->default(5);
            $table->boolean('real_user')->default(true);
            $table->boolean('allow_user')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type');
    }
}
