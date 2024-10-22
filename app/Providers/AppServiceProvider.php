<?php

namespace App\Providers;

use App\Services\ExporterFactories\CsvExportFactory;
use App\Services\ExporterFactories\TxtExportFactory;
use App\Services\ExporterFactories\XmlExportFactory;
use App\Services\Intf\ExportFactoryInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Intf\DumpRepositoryInterface::class,
            \App\Repositories\Storage\DumpRepository::class
        );
        $this->app->bind(
            \App\Services\Intf\DumpParserInterface::class,
            \App\Services\Parsers\SqlDumpParser::class
        );

        $this->app->bind(CsvExportFactory::class, function ($app) {
            return new CsvExportFactory();
        });

        $this->app->bind(XmlExportFactory::class, function ($app) {
            return new XmlExportFactory();
        });

        $this->app->bind(TxtExportFactory::class, function ($app) {
            return new TxtExportFactory();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
