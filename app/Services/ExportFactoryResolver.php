<?php

namespace App\Services;

use App\Enums\ExportType;
use App\Services\ExporterFactories\CsvExportFactory;
use App\Services\ExporterFactories\TxtExportFactory;
use App\Services\ExporterFactories\XmlExportFactory;
use App\Services\Intf\ExportFactoryInterface;
use InvalidArgumentException;

class ExportFactoryResolver
{
    protected array $factories;

    public function __construct(CsvExportFactory $csvFactory, XmlExportFactory $xmlFactory, TxtExportFactory $txtFactory)
    {
        $this->factories = [
            ExportType::CSV->value => $csvFactory,
            ExportType::XML->value => $xmlFactory,
            ExportType::TXT->value => $txtFactory,
        ];
    }

    public function resolve(ExportType $type): ExportFactoryInterface
    {
        if (!array_key_exists($type->value, $this->factories)) {
            throw new InvalidArgumentException("Factory for type '{$type->value}' not found.");
        }

        return $this->factories[$type->value];
    }
}
