<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @property string $symbol
 */
class GetLatestStockRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'symbol' => 'required|string'
        ];
    }
}
