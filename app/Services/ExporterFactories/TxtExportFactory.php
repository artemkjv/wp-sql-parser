<?php

namespace App\Services\ExporterFactories;

use App\Services\Exporters\TxtExporter;
use App\Services\Intf\ExportFactoryInterface;
use App\Services\Intf\ExporterInterface;
use App\Services\Intf\MergerInterface;
use App\Services\Mergers\TxtMerger;

class TxtExportFactory implements ExportFactoryInterface
{

    public function createExporter(): ExporterInterface
    {
        return new TxtExporter();
    }

    public function createMerger(): MergerInterface
    {
        return new TxtMerger();
    }
}
