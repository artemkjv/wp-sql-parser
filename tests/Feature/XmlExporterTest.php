<?php

use App\Services\Exporters\XmlExporter;

it('exports data to an XML file', function () {
    $exporter = new XmlExporter();
    $data = [
        ['title' => 'Title 1', 'content' => 'Content 1'],
    ];

    $filePath = storage_path('app/public/test.xml');
    $exporter->export($data, $filePath);

    $this->assertFileExists($filePath);

    $this->assertStringContainsString('<title>Title 1</title>', file_get_contents($filePath));
    $this->assertStringContainsString('<content>Content 1</content>', file_get_contents($filePath));
});
