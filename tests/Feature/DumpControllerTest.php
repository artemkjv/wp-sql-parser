<?php

namespace Tests\Feature;

use App\Jobs\DumpParseJob;
use App\Models\ParsingResult;
use App\Models\User;
use App\Repositories\Intf\DumpRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('renders the index page with dump names and export types', function () {
    Storage::fake('local');
    Storage::put('dumps/test_dump.sql', 'dummy content');

    $response = $this->get(route('dumps.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('Dumps/Index')
        ->has('dumps', 1)
        ->has('exportTypes'));
});

it('stores a new dump file', function () {
    Storage::fake('local');

    $file = UploadedFile::fake()->create('test_dump.sql', 100);

    $response = $this->post(route('dumps.store'), [
        'dump' => $file,
    ]);

    $response->assertRedirect();
    $this->assertTrue(Storage::exists('dumps/test_dump.sql'));
});

it('does not allow storing a dump file with the same name', function () {
    Storage::fake('local');
    Storage::put('dumps/test_dump.sql', 'dummy content');
    $file = UploadedFile::fake()->create('test_dump.sql', 100);

    $response = $this->post(route('dumps.store'), [
        'dump' => $file,
    ]);

    $response->assertSessionHasErrors(['dump']);
});

it('processes export request successfully', function () {
    Queue::fake();

    $file = UploadedFile::fake()->create('test_dump.sql', 100, 'text/plain');
    app(DumpRepositoryInterface::class)->store('test_dump.sql', 'sample content');

    $response = $this->post(route('dumps.export'), [
        'dumps' => ['test_dump.sql'],
        'export_type' => 'csv',
    ]);

    $parsingResult = ParsingResult::first();

    $response->assertRedirect(route('articles.index', ['uuid' => $parsingResult->uuid]));

    Queue::assertPushed(DumpParseJob::class);
});


it('does not export non-existent dumps', function () {
    Storage::fake('local');

    $response = $this->post(route('dumps.export'), [
        'dumps' => ['non_existent_dump.sql'],
        'export_type' => 'csv',
    ]);

    $response->assertSessionHasErrors(['dumps']);
});

it('destroys a dump file', function () {
    Storage::fake('local');
    Storage::put('dumps/test_dump.sql', 'dummy content');

    $response = $this->delete(route('dumps.destroy', 'test_dump.sql'));

    $response->assertRedirect();
    $this->assertFalse(Storage::exists('dumps/test_dump.sql'));
});
