<?php

use App\Services\Mergers\CsvMerger;

it('merges CSV files correctly', function () {
    $merger = new CsvMerger();

    $file1 = storage_path('app/public/test1.csv');
    $file2 = storage_path('app/public/test2.csv');

    file_put_contents($file1, "Title,Content\nFirst,First content");
    file_put_contents($file2, "Title,Content\nSecond,Second content");

    $mergedPath = storage_path('app/public/merged.csv');
    $merger->merge([$file1, $file2], $mergedPath);

    $this->assertFileExists($mergedPath);
    $this->assertStringContainsString('First,"First content"', file_get_contents($mergedPath));
    $this->assertStringContainsString('Second,"Second content"', file_get_contents($mergedPath));
});
