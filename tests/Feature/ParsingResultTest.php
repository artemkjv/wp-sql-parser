<?php

use App\Enums\ExportType;
use App\Models\ParsingResult;

it('adds resulting file correctly', function () {
    $parsingResult = ParsingResult::create(['uuid' => \Illuminate\Support\Str::uuid(), 'export_type' => ExportType::CSV->value]);
    $parsingResult->addResultingFile('test_dump.sql', 'output.csv');

    expect($parsingResult->resulting_files)->toHaveKey('test_dump.sql')
        ->and($parsingResult->resulting_files['test_dump.sql'])->toBe('output.csv');
});
