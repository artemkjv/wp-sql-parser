<?php

namespace App\Services\Intf;

use App\Enums\ExportType;

#[ExportType]
interface ExportFactoryInterface
{
    public function createExporter(): ExporterInterface;

    public function createMerger(): MergerInterface;
}
