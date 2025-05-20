<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * index
     * @param Request $request
     */
    public function index(Request $request): JsonResponse
    {
        $post = Post::with('user', 'reaction')
            ->withCount(['reaction as reaction_count' => function ($query) {
                $query->select(\DB::raw('count(*)'));
            }])
            ->orderBy('created_at', $request->query('order_by'))
            ->paginate(10);
        
        $post->getCollection()->transform(function ($post) {
            $post->user_reacted = $post->reaction->contains('user_id', Auth::id());
            return $post;
        });

        return response()->json([
            'post' => $post,
        ], 200);
    }

    /**
     * Create new post
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) : JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'content' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'user not found'
                ], 422);
            }

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }
            $request->merge(['user_id' => $user->id]);

            $url = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                $url = Storage::url($path);
            }

            
            $post = Post::create([
                'user_id' => $user->id,
                'content' => $request->content,
                'image' => $url ? $url : null,
            ]);
            
            if (!$url !== null) {
                $post->image = URL::asset($url);
            }

            $post->load('user', 'reaction');
            $post->user_reacted = $post->reaction->contains('user_id', Auth::id());
            $post->reaction_count = $post->reaction->count();

            return response()->json([
                'status' => true,
                'message' => 'Post created successfully',
                'data' => $post,
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating post',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle reaction
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function toggleReaction(Request $request) : JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validate->errors(),
            ], 422);
        }

        try {

            $reaction = Reactions::where('user_id', Auth::id())
                ->where('post_id', $request->post_id)
                ->first();
            
            if ($reaction) {
                $reaction->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'removed',
                ], 200);
            } else {
                Reactions::create([
                    'user_id' => Auth::id(),
                    'post_id' => $request->post_id,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'added',
                ], 201);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error toggling reaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
