<?php

namespace App\Repositories\Storage;

use App\Repositories\Intf\DumpRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DumpRepository implements DumpRepositoryInterface
{

    public function getAllNames(): Collection
    {
        return collect(Storage::files(("dumps")))->map(fn($file) => basename($file));
    }

    public function store(string $name, string $content): void
    {
        Storage::put("dumps/{$name}", $content);
    }

    public function getContentByName(string $name): string
    {
        return Storage::get("dumps/{$name}");
    }

    public function exists(string $name): bool
    {
        return Storage::exists("dumps/{$name}");
    }

    public function deleteByName(string $name): void
    {
        Storage::delete("dumps/{$name}");
    }
}
