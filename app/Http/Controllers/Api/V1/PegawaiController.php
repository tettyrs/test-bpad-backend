<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAkunPegawaiRequest;
use App\Http\Requests\Api\V1\StorePegawaiRequest;
use App\Http\Requests\Api\V1\UpdatePegawaiRequest;
use App\Http\Resources\V1\PegawaiResource;
use App\Http\Responses\ApiError;
use App\Models\Pegawai;
use App\Services\PegawaiAccountService;
use App\Services\PegawaiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class PegawaiController extends Controller
{
    public function __construct(private PegawaiService $service)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        return PegawaiResource::collection($this->service->paginate($filters));
    }

    public function store(StorePegawaiRequest $request): JsonResponse
    {
        $pegawai = $this->service->create($request->validated());

        return (new PegawaiResource($pegawai))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pegawai $pegawai): PegawaiResource
    {
        return new PegawaiResource($pegawai);
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai): PegawaiResource
    {
        return new PegawaiResource(
            $this->service->update($pegawai, $request->validated())
        );
    }

    public function createAccount(StoreAkunPegawaiRequest $request, Pegawai $pegawai, PegawaiAccountService $accounts): JsonResponse
    {
        $user = $accounts->create($pegawai, $request->validated());

        if ($user === null) {
            return ApiError::make('CONFLICT', 'Pegawai ini sudah memiliki akun.', Response::HTTP_CONFLICT);
        }

        return response()->json([
            'data' => [
                'pegawai_id' => $pegawai->id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
        ], Response::HTTP_CREATED);
    }

    public function destroy(Pegawai $pegawai): JsonResponse
    {
        $id = $pegawai->id;

        $this->service->delete($pegawai);

        return response()->json([
            'data' => ['id' => $id, 'deleted' => true],
        ]);
    }
}
