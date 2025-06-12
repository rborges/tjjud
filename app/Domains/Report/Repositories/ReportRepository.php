<?php

namespace App\Domains\Report\Repositories;

use App\Domains\Report\Repositories\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function fetchGroupedReport(): \Illuminate\Support\Collection
    {
        return DB::table('view_book_report')->get();
    }
}
