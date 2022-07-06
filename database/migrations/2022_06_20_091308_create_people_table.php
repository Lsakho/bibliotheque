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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 70);
            $table->string('lastname', 70);
            $table->date('birthdate', 10);
            $table->string('address');
            $table->string('zip', 10);
            $table->string('city', 20);
            $table->string('phone', 20);
            $table->string('email')->unique();
            $table->timestamps();

            $table->string('country_id',3)->index();
            $table->foreign('country_id')
            ->references('iso')
            ->on('countries')
            ->onDelete('restrict')
            ->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
};
