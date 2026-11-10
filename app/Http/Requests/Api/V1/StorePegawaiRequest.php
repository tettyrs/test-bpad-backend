<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:30', Rule::unique('pegawai', 'nip')->whereNull('deleted_at')],
            'jabatan' => ['required', 'string', 'max:255'],
            'golongan' => ['required', 'string', 'max:20'],
        ];
    }
}
