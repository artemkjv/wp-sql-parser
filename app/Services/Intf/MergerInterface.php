<?php

namespace App\Services\Intf;

interface MergerInterface
{
    public function merge(array $files, string $mergedPath): string;
}
