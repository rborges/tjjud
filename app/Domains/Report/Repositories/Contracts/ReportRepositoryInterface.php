<?php

namespace App\Domains\Report\Repositories\Contracts;

interface ReportRepositoryInterface
{
    public function fetchGroupedReport(): \Illuminate\Support\Collection;
}
