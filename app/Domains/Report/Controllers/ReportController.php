<?php

namespace App\Domains\Report\Controllers;

use App\Domains\Report\Services\Contracts\ReportServiceInterface;
use App\Support\ResponseFormatter;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\JsonResponse;

class ReportController
{
    public function __construct(protected ReportServiceInterface $service) {}

    public function index(): JsonResponse
    {
        $grouped = $this->service->getGroupedReport();
        return ResponseFormatter::success($grouped);
    }

    public function exportPdf(PDF $pdf)
    {
        $grouped = $this->service->getGroupedReport();

        $pdf->loadView('report', ['data' => $grouped]);

        $path = storage_path('app/relatorios/relatorio-livros.pdf');
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $pdf->save($path);

        return $pdf->download('relatorio-livros.pdf');
    }
}
