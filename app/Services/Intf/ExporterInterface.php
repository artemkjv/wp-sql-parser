<?php

namespace App\Services\Intf;

interface ExporterInterface
{
    public function export(array $parsedData, string $filePath): string;

}
