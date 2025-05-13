<?php

namespace App\Http\Controllers\Api;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ConfigCollection;
use App\Http\Requests\ConfigStoreRequest;
use App\Http\Requests\ConfigUpdateRequest;

class ConfigController extends Controller
{
    public function index(Request $request): ConfigCollection
    {
        $this->authorize('view-any', Config::class);

        $search = $request->get('search', '');

        $configs = Config::search($search)
            ->latest()
            ->paginate();

        return new ConfigCollection($configs);
    }

    public function store(ConfigStoreRequest $request): ConfigResource
    {
        $this->authorize('create', Config::class);

        $validated = $request->validated();

        $config = Config::create($validated);

        return new ConfigResource($config);
    }

    public function show(Request $request, Config $config): ConfigResource
    {
        $this->authorize('view', $config);

        return new ConfigResource($config);
    }

    public function update(
        ConfigUpdateRequest $request,
        Config $config
    ): ConfigResource {
        $this->authorize('update', $config);

        $validated = $request->validated();

        $config->update($validated);

        return new ConfigResource($config);
    }

    public function destroy(Request $request, Config $config): Response
    {
        $this->authorize('delete', $config);

        $config->delete();

        return response()->noContent();
    }
}
