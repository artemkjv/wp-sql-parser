<?php

namespace App\Services\Intf;

interface DumpParserInterface
{

    public function parse(string $content): array;

}
