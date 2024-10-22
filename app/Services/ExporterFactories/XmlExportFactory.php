<?php

namespace App\Services\ExporterFactories;

use App\Services\Exporters\XmlExporter;
use App\Services\Intf\ExportFactoryInterface;
use App\Services\Intf\ExporterInterface;
use App\Services\Intf\MergerInterface;
use App\Services\Mergers\XmlMerger;

class XmlExportFactory implements ExportFactoryInterface
{

    public function createExporter(): ExporterInterface
    {
        return new XmlExporter();
    }

    public function createMerger(): MergerInterface
    {
        return new XmlMerger();
    }
}
