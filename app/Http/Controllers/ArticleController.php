<?php

namespace App\Http\Controllers;

use App\Enums\ExportType;
use App\Models\ParsingResult;
use App\Services\ExportFactoryResolver;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{


    public function __construct(
        private readonly ExportFactoryResolver $exportFactoryResolver,
    )
    {
    }

    public function index(string $uuid) {
        $parsingResults = ParsingResult::getByUUID($uuid);
        return Inertia::render('Article/Index', compact('parsingResults'));
    }

    public function download(string $fileName) {
        return response()->download(storage_path("app/public/{$fileName}"));
    }

    public function merge(string $uuid) {
        $parsingResult = ParsingResult::getByUUID($uuid);
        $files = $parsingResult->getResultingFilesPath();
        $type = ExportType::tryFrom($parsingResult->export_type);
        $merger = $this->exportFactoryResolver->resolve($type)->createMerger();
        $filePath = storage_path("app/public/{$uuid} - merge.$type->value");
        $merger->merge($files, $filePath);
        return response()->download($filePath);
    }

}
