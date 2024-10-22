<?php

namespace App\Services\Mergers;

use App\Services\Intf\MergerInterface;

class TxtMerger implements MergerInterface
{
    public function merge(array $files, string $mergedPath): string
    {
        $output = fopen($mergedPath, 'w');

        if ($output === false) {
            throw new \Exception("Could not open the file at $mergedPath for writing.");
        }

        foreach ($files as $file) {
            if (file_exists($file) && is_readable($file)) {
                $content = file_get_contents($file);

                fwrite($output, $content . PHP_EOL);
            }
        }

        fclose($output);
        return $mergedPath;
    }
}

