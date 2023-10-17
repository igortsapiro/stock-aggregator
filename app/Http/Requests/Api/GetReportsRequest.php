<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 * @property array $symbols
 */
class GetReportsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'symbols' => ['required', 'array'],
            'symbols.*' => Rule::in(config('stock-aggregator.enabled_stocks')),
        ];
    }
}
