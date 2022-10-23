<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();
            $table->string('first_name',25);
            $table->string('second_name',25)->nullable();
            $table->string('first_surname',25);
            $table->string('second_surname',25)->nullable();
            $table->string('second_email')->unique()->nullable();
            $table->string('cell_phone',10);
            $table->string('landline',10)->nullable();
            $table->string('address',150)->nullable();
            $table->string('workplace',100)->nullable();
            $table->string('position',100)->nullable();
            $table->string('description')->nullable();
            $table->string('role',16);
            $table->foreignId('country_id')->references('id')->on('countries')->restrictOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('user_details');
    }
};
