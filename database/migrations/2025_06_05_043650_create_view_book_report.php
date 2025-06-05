<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW view_book_report AS
            SELECT
                authors.id AS author_id,
                authors.name AS author_name,
                books.id AS book_id,
                books.title AS book_title,
                books.publisher,
                books.edition,
                books.published_year,
                books.price,
                subjects.id AS subject_id,
                subjects.description AS subject_description
            FROM authors
            JOIN author_book ON authors.id = author_book.author_id
            JOIN books ON books.id = author_book.book_id
            LEFT JOIN book_subject ON books.id = book_subject.book_id
            LEFT JOIN subjects ON subjects.id = book_subject.subject_id
            ORDER BY authors.name, books.title;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_book_report");
    }
};
