<?php
namespace App\Http\Controllers\Api;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function join(Group $group, Request $request)
    {
        $user = $request->user();

        if ($group->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Ya eres miembro.'], 400);
        }

        $group->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return response()->json(['message' => 'Te uniste al grupo.']);
    }

    public function leave(Group $group, Request $request)
    {
        $group->members()->detach($request->user()->id);
        return response()->json(['message' => 'Saliste del grupo.']);
    }

    public function index(Group $group)
    {
        return $group->members()->withPivot('role', 'joined_at')->get();
    }
}
