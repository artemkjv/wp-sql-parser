<?php

use App\Services\Parsers\SqlDumpParser;

it('parses SQL content correctly', function () {
    $sqlContent = "INSERT INTO `test_posts` (`post_title`, `post_content`) VALUES ('Title 1', '<a href=\"#\">Content 1</a>'), ('Title 2', '<img src=\"#\" />Content 2');";
    $parser = new SqlDumpParser();
    $result = $parser->parse($sqlContent);
    expect($result)->toHaveCount(2)
        ->and($result[0]['title'])->toBe('Title 1')
        ->and($result[0]['content'])->toBe('Content 1');
});

it('sanitizes content correctly', function () {
    $sqlContent = "INSERT INTO `test_posts` (`post_title`, `post_content`) VALUES ('Title 1', '<a href=\"#\">Content with link</a> and <img src=\"#\" /> image.');";
    $parser = new SqlDumpParser();
    $result = $parser->parse($sqlContent);

    expect($result[0]['content'])->toBe('Content with link and  image.');
});
