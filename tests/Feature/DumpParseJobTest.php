<?php

use App\Jobs\DumpParseJob;
use App\Models\ParsingResult;
use App\Enums\ExportType;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

it('processes dump parsing job', function () {
    Queue::fake();

    $parsingResult = ParsingResult::create(['uuid' => Str::uuid(), 'export_type' => ExportType::CSV->value]);
    $job = new DumpParseJob($parsingResult, 'db2.sql', ExportType::CSV);

    dispatch($job);

    Queue::assertPushed(DumpParseJob::class);
    $exportFactoryResolver = \Illuminate\Support\Facades\App::make(\App\Services\ExportFactoryResolver::class);
    $job->handle(
        new \App\Services\Parsers\SqlDumpParser(),
        new \App\Repositories\Storage\DumpRepository(),
        $exportFactoryResolver
    );

    expect($parsingResult->resulting_files)->toHaveKey('db2.sql');
});
