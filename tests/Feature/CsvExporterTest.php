<?php

use App\Services\Exporters\CsvExporter;

it('exports data to a CSV file', function () {
    $exporter = new CsvExporter();
    $data = [
        ['title' => 'Title 1', 'content' => 'Content 1'],
    ];

    $filePath = storage_path('app/public/test.csv');
    $exporter->export($data, $filePath);

    $this->assertFileExists($filePath);
    $this->assertStringContainsString('"Title 1","Content 1"', file_get_contents($filePath));
});
