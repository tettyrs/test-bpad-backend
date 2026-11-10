<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['sometimes', 'required', 'string', 'max:255'],
            'nip' => [
                'sometimes',
                'required',
                'string',
                'max:30',
                Rule::unique('pegawai', 'nip')
                    ->ignore($this->route('pegawai'))
                    ->whereNull('deleted_at'),
            ],
            'jabatan' => ['sometimes', 'required', 'string', 'max:255'],
            'golongan' => ['sometimes', 'required', 'string', 'max:20'],
        ];
    }
}
