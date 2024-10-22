<?php

namespace App\Services\Exporters;

use App\Services\Intf\ExporterInterface;

class TxtExporter implements ExporterInterface
{

    public function export(array $parsedData, string $filePath): string
    {
        $fileHandle = fopen($filePath, 'w');

        if ($fileHandle === false) {
            throw new \Exception("Could not open the file for writing.");
        }

        foreach ($parsedData as $data) {
            $line = "Title: " . $data['title'] . "\nContent: " . $data['content'] . "\n\n";
            fwrite($fileHandle, $line);
        }

        fclose($fileHandle);

        return $filePath;
    }
}
