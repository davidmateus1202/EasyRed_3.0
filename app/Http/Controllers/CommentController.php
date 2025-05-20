<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Create new comment
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $validate = Validator::make($request->all(), [
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
            'content' => 'required|string|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 422);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'data' => $comment,
        ], 201);

        try {

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating comment',
            ], 500);
        }
    }
}
