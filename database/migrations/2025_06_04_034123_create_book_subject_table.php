<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('book_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->comment('Referência ao livro');
            $table->unsignedBigInteger('subject_id')->comment('Referência ao assunto');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            $table->primary(['book_id', 'subject_id'], 'Livro_assunto_PK');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_subject');
    }
};
