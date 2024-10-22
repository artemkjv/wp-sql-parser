<?php

namespace App\Services\Parsers;

use App\Services\Intf\DumpParserInterface;

class SqlDumpParser implements DumpParserInterface
{

    public function parse(string $content): array
    {
        $insertStatement = $this->extractInsertStatement($content);
        $columns = $this->extractColumns($insertStatement);
        $valuesString = $this->extractValues($insertStatement);
        return $this->parseRows($columns, $valuesString);
    }

    private function extractInsertStatement(string $content): string
    {
        preg_match('/INSERT INTO `[A-Za-z0-9]+_posts` \([^)]*\).*?\);/s', $content, $matches);
        return array_shift($matches);
    }

    private function extractColumns(string $insertStatement): array
    {
        preg_match("/INSERT INTO `[A-Za-z0-9]+_posts` \((.+)\) VALUES/", $insertStatement, $matches);
        $cleanedColumns = preg_replace('/`/', '', $matches[1]);
        return explode(", ", $cleanedColumns);
    }

    private function extractValues(string $insertStatement): string
    {
        preg_match("/VALUES\s*(.+);$/is", $insertStatement, $matches);
        return $matches[1];
    }

    private function parseRows(array $columns, string $valuesString): array
    {
        preg_match_all('/\(([^()]*|(?R))*\)/', $valuesString, $matches);
        $valueRows = $matches[0];
        $data = [];

        foreach ($valueRows as $row) {
            $row = trim($row, '()');
            $rowValues = str_getcsv($row, ',', "'");
            $article = array_combine($columns, $rowValues);
            $article['post_content'] = $this->sanitizeContent($article['post_content']);
            $data[] = [
                'title' => $article['post_title'],
                'content' => $article['post_content'],
            ];
        }

        return $data;
    }

    private function sanitizeContent(string $content): string
    {
        $contentWithoutLinks = preg_replace('/<a\s+[^>]*>(.*?)<\/a>/is', '$1', $content);
        return preg_replace('/<img\s+[^>]*>/i', '', $contentWithoutLinks);
    }


}
