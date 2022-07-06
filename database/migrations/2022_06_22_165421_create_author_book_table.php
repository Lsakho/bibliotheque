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
        Schema::create('author_book', function (Blueprint $table) {
            $table->string('book_isbn',13)->index();
            $table->foreign('book_isbn')
            ->references('isbn')
            ->on('books')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
            ->references('id')
            ->on('authors')
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
        Schema::dropIfExists('author_book');
    }
};
