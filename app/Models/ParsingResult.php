<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParsingResult extends Model
{
    protected $fillable = [
        'uuid',
        'resulting_files',
        'export_type'
    ];

    protected $casts = [
        'resulting_files' => 'array'
    ];

    public function addResultingFile(string $dumpName, string $file): void
    {
        $resultingFiles = $this->resulting_files;
        $resultingFiles[$dumpName] = $file;
        $this->resulting_files = $resultingFiles;
        $this->save();
    }

    public static function getByUUID(string $uuid): self
    {
        return self::where('uuid', $uuid)->firstOrFail();
    }

    public function getResultingFilesPath(): array {
        return array_map(function ($file) {
            return storage_path("app/public/{$file}");
        }, $this->resulting_files);
    }

}
