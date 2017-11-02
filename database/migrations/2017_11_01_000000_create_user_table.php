<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->default(1);
            $table->unsignedInteger('type_id')->default(0);
            $table->string('username', 32)->unique();
            $table->string('password', 64);
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('company')->nullable();
            $table->timestamps();

            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
