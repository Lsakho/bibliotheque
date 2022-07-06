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
        Schema::create('book_people', function (Blueprint $table) {
            $table->string('book_isbn',13)->index();
            $table->foreign('book_isbn')
            ->references('isbn')
            ->on('books')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')
            ->references('id')
            ->on('people')
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
        Schema::dropIfExists('book_people');
    }
};
