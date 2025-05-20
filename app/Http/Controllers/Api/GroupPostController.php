<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupPost;
use Illuminate\Http\Request;

class GroupPostController extends Controller
{
    public function index(Group $group)
    {
        return response()->json(
            $group->posts()->with('user')->latest()->get()
        );
    }

    public function store(Request $request, $groupId)
    {
        \Log::info('🛠️ [STORE POST] Request recibido', [
            'user_id' => auth()->id(),
            'group_id' => $groupId,
            'data' => $request->all()
        ]);

        if (!auth()->check()) {
            \Log::warning('❌ [STORE POST] Usuario no autenticado');
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $validated = $request->validate([
            'content' => 'required|string',
            'type' => 'nullable|string|in:text,image,file_link,video_link',
            'media_url' => 'nullable|string',
        ]);

        $post = GroupPost::create([
            'group_id' => $groupId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'type' => $validated['type'] ?? 'text',
            'media_url' => $validated['media_url'] ?? null,
        ]);

        \Log::info('✅ [STORE POST] Post creado correctamente', [
            'post_id' => $post->id,
        ]);

        return response()->json($post->load('user'), 201);
    }
}
