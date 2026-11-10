<?php

namespace App\Http\Requests\Api\V1;

use App\Models\KendaraanDinas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKendaraanDinasRequest extends FormRequest
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
            'nomor_polisi' => ['required', 'string', 'max:20', 'regex:/^[A-Z]{1,2} ?\d{1,4} ?[A-Z]{0,3}$/', Rule::unique('kendaraan_dinas', 'nomor_polisi')->whereNull('deleted_at')],
            'merk_kendaraan' => ['required', 'string', 'max:100'],
            'tipe_kendaraan' => ['nullable', 'string', 'max:100'],
            'tahun_produksi' => ['required', 'integer', 'between:1950,'.(now()->year + 1)],
            'warna_kendaraan' => ['required', 'string', 'max:50'],
            'kondisi' => ['required', Rule::in(KendaraanDinas::KONDISI)],
            'perangkat_daerah_id' => ['required', 'integer', 'exists:perangkat_daerah,id'],
            'pegawai_id' => ['nullable', 'integer', 'exists:pegawai,id'],
        ];
    }
}
