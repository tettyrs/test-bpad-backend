<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreKendaraanDinasRequest;
use App\Http\Requests\Api\V1\UpdateKendaraanDinasRequest;
use App\Http\Resources\V1\KendaraanDinasResource;
use App\Models\KendaraanDinas;
use App\Services\KendaraanDinasService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class KendaraanDinasController extends Controller
{
    public function __construct(private KendaraanDinasService $service)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kondisi' => ['nullable', Rule::in(KendaraanDinas::KONDISI)],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        return KendaraanDinasResource::collection($this->service->paginate($filters));
    }

    public function store(StoreKendaraanDinasRequest $request): JsonResponse
    {
        $kendaraanDinas = $this->service->create($request->validated());

        return (new KendaraanDinasResource($kendaraanDinas))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(KendaraanDinas $kendaraanDinas): KendaraanDinasResource
    {
        return new KendaraanDinasResource($kendaraanDinas->load(['perangkatDaerah', 'pegawai']));
    }

    public function update(UpdateKendaraanDinasRequest $request, KendaraanDinas $kendaraanDinas): KendaraanDinasResource
    {
        return new KendaraanDinasResource(
            $this->service->update($kendaraanDinas, $request->validated())
        );
    }

    public function destroy(KendaraanDinas $kendaraanDinas): JsonResponse
    {
        $id = $kendaraanDinas->id;

        $this->service->delete($kendaraanDinas);

        return response()->json([
            'data' => ['id' => $id, 'deleted' => true],
        ]);
    }
}
