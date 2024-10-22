<?php

use App\Services\Exporters\TxtExporter;


it('exports data to a TXT file', function () {
    $exporter = new TxtExporter();
    $data = [
        ['title' => 'Title 1', 'content' => 'Content 1'],
    ];

    $filePath = storage_path('app/public/test.txt');
    $exporter->export($data, $filePath);

    $this->assertFileExists($filePath);
    $message = <<<EOT
    Title: Title 1
    Content: Content 1

    EOT;

    $this->assertStringContainsString($message, file_get_contents($filePath));
});
