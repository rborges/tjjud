<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $data = DB::table('view_book_report')->get();

        $grouped = $data->groupBy('author_id')->map(function ($items) {
            return [
                'autor' => $items->first()->author_name,
                'livros' => $items->groupBy('book_id')->map(function ($bookItems) {
                    return [
                        'título' => $bookItems->first()->book_title,
                        'editora' => $bookItems->first()->publisher,
                        'edição' => $bookItems->first()->edition,
                        'ano_publicação' => $bookItems->first()->published_year,
                        'preço' => $bookItems->first()->price,
                        'assuntos' => $bookItems->pluck('subject_description')->unique()->values()
                    ];
                })->values()
            ];
        })->values();

        return response()->json($grouped);
    }

    public function exportPdf()
    {
        $data = DB::table('view_book_report')->get();

        $agrupado = $data->groupBy('author_id')->map(function ($items) {
            return [
                'autor' => $items->first()->author_name,
                'livros' => $items->groupBy('book_id')->map(function ($bookItems) {
                    return [
                        'título' => $bookItems->first()->book_title,
                        'editora' => $bookItems->first()->publisher,
                        'edição' => $bookItems->first()->edition,
                        'ano_publicação' => $bookItems->first()->published_year,
                        'preço' => $bookItems->first()->price,
                        'assuntos' => $bookItems->pluck('subject_description')->unique()->values()
                    ];
                })->values()
            ];
        })->values();

        /** @var PDF $pdf */
        $pdf = app(PDF::class);
        $pdf->loadView('report', ['data' => $agrupado]);

        // Salva localmente
        $path = storage_path('app/relatorios/relatorio-livros.pdf');
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        $pdf->save($path);

        // Força download
        return $pdf->download('relatorio-livros.pdf');
    }
}
