<?php

use App\Services\Mergers\TxtMerger;

it('merges TXT files correctly', function () {
    $merger = new TxtMerger();

    $file1 = storage_path('app/public/test1.txt');
    $file2 = storage_path('app/public/test2.txt');

    file_put_contents($file1, "First: First content\n");
    file_put_contents($file2, "Second: Second content\n");

    $mergedPath = storage_path('app/public/merged.txt');
    $merger->merge([$file1, $file2], $mergedPath);

    $this->assertFileExists($mergedPath);

    $content = file_get_contents($mergedPath);
    $this->assertStringContainsString('First: First content', $content);
    $this->assertStringContainsString('Second: Second content', $content);
});
