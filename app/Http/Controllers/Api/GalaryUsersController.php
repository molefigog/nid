<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Galary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class GalaryUsersController extends Controller
{
    public function index(Request $request, Galary $galary): UserCollection
    {
        $this->authorize('view', $galary);

        $search = $request->get('search', '');

        $users = $galary
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(
        Request $request,
        Galary $galary,
        User $user
    ): Response {
        $this->authorize('update', $galary);

        $galary->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Galary $galary,
        User $user
    ): Response {
        $this->authorize('update', $galary);

        $galary->users()->detach($user);

        return response()->noContent();
    }
}
