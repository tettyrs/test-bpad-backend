<?php

namespace App\Http\Requests\Api\V1;

use App\Models\KendaraanDinas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKendaraanDinasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (is_string($this->nomor_polisi)) {
            $this->merge([
                'nomor_polisi' => strtoupper(preg_replace('/\s+/', ' ', trim($this->nomor_polisi))),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nomor_polisi' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                'regex:/^[A-Z]{1,2} ?\d{1,4} ?[A-Z]{0,3}$/',
                Rule::unique('kendaraan_dinas', 'nomor_polisi')
                    ->ignore($this->route('kendaraanDinas'))
                    ->whereNull('deleted_at'),
            ],
            'merk_kendaraan' => ['sometimes', 'required', 'string', 'max:100'],
            'tipe_kendaraan' => ['sometimes', 'nullable', 'string', 'max:100'],
            'tahun_produksi' => ['sometimes', 'required', 'integer', 'between:1950,'.(now()->year + 1)],
            'warna_kendaraan' => ['sometimes', 'required', 'string', 'max:50'],
            'kondisi' => ['sometimes', 'required', Rule::in(KendaraanDinas::KONDISI)],
            'perangkat_daerah_id' => ['sometimes', 'required', 'integer', 'exists:perangkat_daerah,id'],
            'pegawai_id' => ['sometimes', 'nullable', 'integer', 'exists:pegawai,id'],
        ];
    }
}
