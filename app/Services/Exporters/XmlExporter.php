<?php

namespace App\Services\Exporters;

use App\Services\Intf\ExporterInterface;

class XmlExporter implements ExporterInterface
{

    public function export(array $parsedData, string $filePath): string
    {
        $xml = new \SimpleXMLElement('<root/>');

        foreach ($parsedData as $data) {
            $item = $xml->addChild('item');
            $item->addChild('title', htmlspecialchars($data['title']));
            $item->addChild('content', htmlspecialchars($data['content']));
        }

        $xml->asXML($filePath);

        return $filePath;
    }
}
