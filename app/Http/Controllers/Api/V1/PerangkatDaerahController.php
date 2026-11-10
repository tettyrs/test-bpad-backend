<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePerangkatDaerahRequest;
use App\Http\Requests\Api\V1\UpdatePerangkatDaerahRequest;
use App\Http\Resources\V1\PerangkatDaerahResource;
use App\Models\PerangkatDaerah;
use App\Services\PerangkatDaerahService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class PerangkatDaerahController extends Controller
{
    public function __construct(private PerangkatDaerahService $service)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        return PerangkatDaerahResource::collection($this->service->paginate($filters));
    }

    public function store(StorePerangkatDaerahRequest $request): JsonResponse
    {
        $perangkatDaerah = $this->service->create($request->validated());

        return (new PerangkatDaerahResource($perangkatDaerah))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PerangkatDaerah $perangkatDaerah): PerangkatDaerahResource
    {
        return new PerangkatDaerahResource($perangkatDaerah);
    }

    public function update(UpdatePerangkatDaerahRequest $request, PerangkatDaerah $perangkatDaerah): PerangkatDaerahResource
    {
        return new PerangkatDaerahResource(
            $this->service->update($perangkatDaerah, $request->validated())
        );
    }

    public function destroy(PerangkatDaerah $perangkatDaerah): JsonResponse
    {
        $id = $perangkatDaerah->id;

        $this->service->delete($perangkatDaerah);

        return response()->json([
            'data' => ['id' => $id, 'deleted' => true],
        ]);
    }
}
