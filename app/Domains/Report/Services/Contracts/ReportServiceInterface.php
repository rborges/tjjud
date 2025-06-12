<?php

namespace App\Domains\Report\Services\Contracts;

use Illuminate\Support\Collection;

interface ReportServiceInterface
{
    public function getGroupedReport(): Collection;
}
