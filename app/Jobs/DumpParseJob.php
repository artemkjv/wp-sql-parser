<?php

namespace App\Jobs;

use App\Enums\ExportType;
use App\Events\ParsingCompleted;
use App\Models\ParsingResult;
use App\Repositories\Intf\DumpRepositoryInterface;
use App\Services\ExporterFactories\CsvExportFactory;
use App\Services\ExporterFactories\TxtExportFactory;
use App\Services\ExporterFactories\XmlExportFactory;
use App\Services\ExportFactoryResolver;
use App\Services\Intf\DumpParserInterface;
use App\Services\Intf\ExporterInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\App;

class DumpParseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly ParsingResult $parsingResult,
        private readonly string        $dumpName,
        private readonly ExportType    $exportType,
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(
        DumpParserInterface $dumpParser,
        DumpRepositoryInterface $dumpRepository,
        ExportFactoryResolver $exportFactoryResolver
    ): void
    {
        $exporter = $exportFactoryResolver->resolve($this->exportType)->createExporter();

        $content = $dumpRepository->getContentByName($this->dumpName);
        $articles = $dumpParser->parse($content);
        $dumpNameWithoutExtension = pathinfo($this->dumpName, PATHINFO_FILENAME);

        $fileName = "{$this->parsingResult->uuid} | $dumpNameWithoutExtension.{$this->exportType->value}";
        $exporter->export($articles, storage_path("app/public/{$fileName}"));
        $this->parsingResult->addResultingFile($this->dumpName, $fileName);
        ParsingCompleted::dispatch($this->parsingResult);
    }
}
