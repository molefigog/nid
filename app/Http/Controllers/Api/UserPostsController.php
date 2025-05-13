<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class UserPostsController extends Controller
{
    public function index(Request $request, User $user): PostCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $posts = $user
            ->posts()
            ->search($search)
            ->latest()
            ->paginate();

        return new PostCollection($posts);
    }

    public function store(Request $request, User $user, Post $post): Response
    {
        $this->authorize('update', $user);

        $user->posts()->syncWithoutDetaching([$post->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, User $user, Post $post): Response
    {
        $this->authorize('update', $user);

        $user->posts()->detach($post);

        return response()->noContent();
    }
}
