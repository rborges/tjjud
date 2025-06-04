<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('author_book', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->comment('Referência ao livro');
            $table->unsignedBigInteger('author_id')->comment('Referência ao autor');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');

            $table->primary(['book_id', 'author_id'], 'Livro_autor_PK');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};
