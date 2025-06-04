<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id()->comment('Identificador único do livro');
            $table->string('title', 40)->comment('Título do livro');
            $table->string('publisher', 40)->comment('Nome da editora');
            $table->integer('edition')->comment('Número da edição do livro');
            $table->string('published_year', 4)->comment('Ano de publicação');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}
