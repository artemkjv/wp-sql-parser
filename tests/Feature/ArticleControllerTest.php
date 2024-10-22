<?php

namespace Tests\Feature;

use App\Enums\ExportType;
use App\Models\ParsingResult;
use App\Models\User;
use App\Services\ExportFactoryResolver;
use Illuminate\Support\Str;
use Inertia\Inertia;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the article index with the parsing results', function () {
    $uuid = Str::uuid()->toString();
    $parsingResult = ParsingResult::create([
        'uuid' => $uuid,
        'export_type' => ExportType::CSV->value,
        'resulting_files' => ['test_dump.sql' => 'output.csv']
    ]);

    $response = $this->get(route('articles.index', ['uuid' => $uuid]));

    $response->assertSuccessful();

    $response->assertInertia(fn ($page) => $page
        ->component('Article/Index')
        ->where('parsingResults.uuid', $uuid)
        ->where('parsingResults.export_type', ExportType::CSV->value)
    );
});

it('downloads the resulting file', function () {
    $fileName = 'test_file.csv';
    $path = storage_path("app/public/{$fileName}");

    file_put_contents($path, 'Sample content');

    $response = $this->get(route('articles.download', ['fileName' => $fileName]));

    $response->assertDownload($fileName);
});
