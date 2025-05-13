<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SettingCollection;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\SettingUpdateRequest;

class SettingController extends Controller
{
    public function index(Request $request): SettingCollection
    {
        $this->authorize('view-any', Setting::class);

        $search = $request->get('search', '');

        $settings = Setting::search($search)
            ->latest()
            ->paginate();

        return new SettingCollection($settings);
    }

    public function store(SettingStoreRequest $request): SettingResource
    {
        $this->authorize('create', Setting::class);

        $validated = $request->validated();

        $setting = Setting::create($validated);

        return new SettingResource($setting);
    }

    public function show(Request $request, Setting $setting): SettingResource
    {
        $this->authorize('view', $setting);

        return new SettingResource($setting);
    }

    public function update(
        SettingUpdateRequest $request,
        Setting $setting
    ): SettingResource {
        $this->authorize('update', $setting);

        $validated = $request->validated();

        $setting->update($validated);

        return new SettingResource($setting);
    }

    public function destroy(Request $request, Setting $setting): Response
    {
        $this->authorize('delete', $setting);

        $setting->delete();

        return response()->noContent();
    }
}
