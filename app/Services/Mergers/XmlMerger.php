<?php

namespace App\Services\Mergers;

use App\Services\Intf\MergerInterface;

class XmlMerger implements MergerInterface
{
    public function merge(array $files, string $mergedPath): string
    {
        $mergedXml = new \DOMDocument('1.0', 'UTF-8');

        $root = $mergedXml->createElement('articles');
        $mergedXml->appendChild($root);

        foreach ($files as $file) {
            if (file_exists($file) && is_readable($file)) {
                $xml = new \DOMDocument();
                $xml->load($file);

                foreach ($xml->documentElement->childNodes as $child) {
                    $imported = $mergedXml->importNode($child, true);
                    $root->appendChild($imported);
                }
            }
        }

        $mergedXml->save($mergedPath);
        return $mergedPath;
    }
}
