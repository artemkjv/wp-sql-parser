<?php

namespace App\Services\Exporters;

use App\Services\Intf\ExporterInterface;

class CsvExporter implements ExporterInterface
{

    public function export(array $parsedData, string $filePath): string
    {
        $fileHandle = fopen($filePath, 'w');

        if ($fileHandle === false) {
            throw new \Exception("Could not open the file for writing.");
        }

        fputcsv($fileHandle, ['Title', 'Content']);

        foreach ($parsedData as $data) {
            fputcsv($fileHandle, [$data['title'], $data['content']]);
        }

        fclose($fileHandle);

        return $filePath;
    }

}
