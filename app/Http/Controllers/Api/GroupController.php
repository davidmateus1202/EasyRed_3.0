<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        return Group::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:groups',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_private' => $request->is_private ?? false,
            'creator_id' => Auth::id(), // asegúrate que estás autenticado
            'slug' => Str::slug($request->name),
        ]);

        return response()->json($group, 201);
    }

    public function show($id)
    {
        return Group::with('members', 'posts')->findOrFail($id);
    }
}
