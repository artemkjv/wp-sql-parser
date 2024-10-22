<?php

namespace App\Services\Mergers;

use App\Services\Intf\MergerInterface;

class CsvMerger implements MergerInterface
{

    public function merge(array $files, string $mergedPath): string
    {
        $output = fopen($mergedPath, 'w');

        if ($output === false) {
            throw new \Exception("Could not open the file at $mergedPath for writing.");
        }

        $headerWritten = false;

        foreach ($files as $file) {
            if (($handle = fopen($file, 'r')) !== false) {
                $header = fgetcsv($handle);

                if (!$headerWritten && $header) {
                    fputcsv($output, $header);
                    $headerWritten = true;
                }

                while (($data = fgetcsv($handle)) !== false) {
                    fputcsv($output, $data);
                }

                fclose($handle);
            }
        }

        fclose($output);
        return $mergedPath;
    }

}
