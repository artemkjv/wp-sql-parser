<?php

namespace App\Repositories\Intf;

use Illuminate\Support\Collection;

interface DumpRepositoryInterface
{

    public function getAllNames(): Collection;

    public function store(string $name, string $content): void;

    public function getContentByName(string $name): string;

    public function exists(string $name): bool;

    public function deleteByName(string $name): void;

}
