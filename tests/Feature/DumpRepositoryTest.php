<?php

use App\Repositories\Storage\DumpRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

beforeEach(function () {
    $this->repository = new DumpRepository();

    Storage::fake('local');
});

it('stores a dump file', function () {
    $fileName = 'test_dump.sql';
    $fileContent = 'INSERT INTO `example_posts` (`post_title`, `post_content`) VALUES ("Test Title", "Test Content")';

    $this->repository->store($fileName, $fileContent);

    Storage::disk('local')->assertExists("dumps/{$fileName}");
});

it('retrieves the content of a dump file', function () {
    $fileName = 'test_dump.sql';
    $fileContent = 'INSERT INTO `example_posts` (`post_title`, `post_content`) VALUES ("Test Title", "Test Content")';

    $this->repository->store($fileName, $fileContent);

    $retrievedContent = $this->repository->getContentByName($fileName);
    expect($retrievedContent)->toBe($fileContent);
});

it('returns true if the dump file exists', function () {
    $fileName = 'existing_dump.sql';
    $fileContent = 'Some content';

    $this->repository->store($fileName, $fileContent);

    expect($this->repository->exists($fileName))->toBeTrue();
});

it('returns false if the dump file does not exist', function () {
    expect($this->repository->exists('non_existing_dump.sql'))->toBeFalse();
});

it('deletes a dump file', function () {
    $fileName = 'delete_me.sql';
    $fileContent = 'Some content';

    $this->repository->store($fileName, $fileContent);

    $this->repository->deleteByName($fileName);

    Storage::disk('local')->assertMissing("dumps/{$fileName}");
});

it('retrieves all dump file names', function () {
    $this->repository->store('first_dump.sql', '...');
    $this->repository->store('second_dump.sql', '...');
    $this->repository->store('third_dump.sql', '...');

    $fileNames = $this->repository->getAllNames();

    expect($fileNames)->toBeInstanceOf(Collection::class)
        ->and($fileNames)->toMatchArray(['first_dump.sql', 'second_dump.sql', 'third_dump.sql']);
});
