<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('status_id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('admin_id')->default(0);
            $table->string('user_id', 20);
            $table->string('user_name', 10);
            $table->string('user_mobile', 20);
            $table->text('user_description');
            $table->unsignedInteger('user_star')->default(5);
            $table->text('user_evaluation')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('repaired_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index('user_id');
            $table->index('user_mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair');
    }
}
