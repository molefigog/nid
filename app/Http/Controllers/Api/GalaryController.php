<?php

namespace App\Http\Controllers\Api;

use App\Models\Galary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GalaryResource;
use App\Http\Resources\GalaryCollection;
use App\Http\Requests\GalaryStoreRequest;
use App\Http\Requests\GalaryUpdateRequest;

class GalaryController extends Controller
{
    public function index(Request $request): GalaryCollection
    {
        $this->authorize('view-any', Galary::class);

        $search = $request->get('search', '');

        $galaries = Galary::search($search)
            ->latest()
            ->paginate();

        return new GalaryCollection($galaries);
    }

    public function store(GalaryStoreRequest $request): GalaryResource
    {
        $this->authorize('create', Galary::class);

        $validated = $request->validated();
        $validated['image_path'] = json_decode($validated['image_path'], true);

        $galary = Galary::create($validated);

        return new GalaryResource($galary);
    }

    public function show(Request $request, Galary $galary): GalaryResource
    {
        $this->authorize('view', $galary);

        return new GalaryResource($galary);
    }

    public function update(
        GalaryUpdateRequest $request,
        Galary $galary
    ): GalaryResource {
        $this->authorize('update', $galary);

        $validated = $request->validated();

        $validated['image_path'] = json_decode($validated['image_path'], true);

        $galary->update($validated);

        return new GalaryResource($galary);
    }

    public function destroy(Request $request, Galary $galary): Response
    {
        $this->authorize('delete', $galary);

        $galary->delete();

        return response()->noContent();
    }
}
