<?php
namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class PostUsersController extends Controller
{
    public function index(Request $request, Post $post): UserCollection
    {
        $this->authorize('view', $post);

        $search = $request->get('search', '');

        $users = $post
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Post $post, User $user): Response
    {
        $this->authorize('update', $post);

        $post->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Post $post, User $user): Response
    {
        $this->authorize('update', $post);

        $post->users()->detach($user);

        return response()->noContent();
    }
}
