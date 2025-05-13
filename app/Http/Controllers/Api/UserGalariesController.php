<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Galary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GalaryCollection;

class UserGalariesController extends Controller
{
    public function index(Request $request, User $user): GalaryCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $galaries = $user
            ->galaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new GalaryCollection($galaries);
    }

    public function store(
        Request $request,
        User $user,
        Galary $galary
    ): Response {
        $this->authorize('update', $user);

        $user->galaries()->syncWithoutDetaching([$galary->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        User $user,
        Galary $galary
    ): Response {
        $this->authorize('update', $user);

        $user->galaries()->detach($galary);

        return response()->noContent();
    }
}
