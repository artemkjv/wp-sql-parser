<?php

use App\Services\Mergers\XmlMerger;

it('merges XML files correctly', function () {
    $merger = new XmlMerger();

    $file1 = storage_path('app/public/test1.xml');
    $file2 = storage_path('app/public/test2.xml');

    file_put_contents($file1, '<?xml version="1.0"?><articles><article><title>First</title><content>First content</content></article></articles>');
    file_put_contents($file2, '<?xml version="1.0"?><articles><article><title>Second</title><content>Second content</content></article></articles>');

    $mergedPath = storage_path('app/public/merged.xml');
    $merger->merge([$file1, $file2], $mergedPath);

    $this->assertFileExists($mergedPath);

    $content = file_get_contents($mergedPath);
    $this->assertStringContainsString('<title>First</title>', $content);
    $this->assertStringContainsString('<content>First content</content>', $content);
    $this->assertStringContainsString('<title>Second</title>', $content);
    $this->assertStringContainsString('<content>Second content</content>', $content);
});
