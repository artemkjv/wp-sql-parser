<?php

namespace App\Http\Requests\Dump;

use App\Enums\ExportType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dumps' => 'required|array',
            'dumps.*' => 'string',
            'export_type' => ['required', 'string', Rule::in(ExportType::values())]
        ];
    }
}
