<?php

namespace App\Services\ExporterFactories;

use App\Services\Exporters\CsvExporter;
use App\Services\Intf\ExporterInterface;
use App\Services\Intf\ExportFactoryInterface;
use App\Services\Intf\MergerInterface;
use App\Services\Mergers\CsvMerger;

class CsvExportFactory implements ExportFactoryInterface
{

    public function createExporter(): ExporterInterface
    {
        return new CsvExporter();
    }

    public function createMerger(): MergerInterface
    {
        return new CsvMerger();
    }
}
