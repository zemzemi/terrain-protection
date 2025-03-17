<?php

namespace App\Http\Requests;

use App\Rules\AltitudeRule;
use Illuminate\Foundation\Http\FormRequest;

class TerrainProtectionRequest extends FormRequest
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
            'width' => ['required', 'integer', 'min:1'],
            'altitudes' => ['required', 'string', new AltitudeRule($this->input('width'))],
        ];
    }
}
