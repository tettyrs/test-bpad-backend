<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePerangkatDaerahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_pd' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('perangkat_daerah', 'kode_pd')
                    ->ignore($this->route('perangkatDaerah'))
                    ->whereNull('deleted_at'),
            ],
            'nama' => ['sometimes', 'required', 'string', 'max:255'],
            'alamat' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }
}
