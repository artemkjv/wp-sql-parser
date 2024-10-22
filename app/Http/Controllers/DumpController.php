<?php

namespace App\Http\Controllers;

use App\Enums\ExportType;
use App\Http\Requests\Dump\ExportRequest;
use App\Http\Requests\Dump\StoreRequest;
use App\Jobs\DumpParseJob;
use App\Models\ParsingResult;
use App\Repositories\Intf\DumpRepositoryInterface;
use App\Services\Intf\DumpParserInterface;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class DumpController extends Controller
{
    public function __construct(private DumpRepositoryInterface $dumpRepository)
    {
    }

    public function index()
    {
        $dumps = $this->dumpRepository->getAllNames();
        $exportTypes = ExportType::values();
        return Inertia::render('Dumps/Index', compact('dumps', 'exportTypes'));
    }

    public function store(StoreRequest $request)
    {
        $payload = $request->validated();
        if($this->dumpRepository->exists($payload['dump']->getClientOriginalName())){
            throw ValidationException::withMessages([
                'dump' => 'Dump with this name already exists'
            ]);
        }
        $this->dumpRepository->store($payload['dump']->getClientOriginalName(), $payload['dump']->getContent());
        return back();
    }

    public function export(ExportRequest $request) {
        $payload = $request->validated();
        foreach ($payload['dumps'] as $dump) {
            if(!$this->dumpRepository->exists($dump)){
                throw ValidationException::withMessages([
                    'dumps' => "Dump with name $dump does not exist"
                ]);
            }
        }

        $parsingResult = ParsingResult::create([
            'uuid' => Str::uuid(),
            'export_type' => $payload['export_type'],
        ]);

        foreach ($payload['dumps'] as $dump) {
            DumpParseJob::dispatch($parsingResult, $dump, ExportType::from($payload['export_type']));
        }

        return to_route('articles.index', ['uuid' => $parsingResult->uuid]);
    }

    public function destroy(string $name)
    {
        $this->dumpRepository->deleteByName($name);
        return back();
    }
}
