<?php

namespace App\Domains\Report\Services;

use App\Domains\Report\Repositories\Contracts\ReportRepositoryInterface;
use App\Domains\Report\Services\Contracts\ReportServiceInterface;
use Illuminate\Support\Collection;

class ReportService implements ReportServiceInterface
{
    public function __construct(protected ReportRepositoryInterface $repo) {}

    public function getGroupedReport(): Collection
    {
        $data = $this->repo->fetchGroupedReport();

        return $data->groupBy('author_id')->map(function ($items) {
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
    }
}
