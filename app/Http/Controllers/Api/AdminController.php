<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Report;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalReports = Report::count();
        $pending = Report::where('status', 'pending')->count();
        $admin = User::role('admin')->count();
        $masyarakat = User::role('masyarakat')->count();
        $petugas = User::role('petugas')->count();

        return response()->json([
            'success' => true,
            'message' => 'Statistik Dashboard Admin',
            'data' => [
                'total_reports' => $totalReports,
                'status_pending' => $pending,
                'total_user' => $masyarakat + $petugas + $admin,
                'total_masyarakat' => $masyarakat,
                'total_petugas' => $petugas,
                'total_admin' => $admin,
            ]
        ]);
    }
    public function updateRole(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);
        $user = auth()->user();
        $request->validate([
            'role' => 'required|in:petugas,masyarakat,admin'
        ]);

        if ($targetUser->hasRole($request->role)) {
            return response()->json([
                'message' => 'Role tidak boleh sama!',
            ], 400);
        }


        Gate::authorize('updateRole', [$targetUser, $request->role]);

        $targetUser->syncRoles($request->role);

        $targetUser->refresh();

        return (new UserResource($targetUser))->additional([
            'success' => true,
            'message' => "Berhasil! sekarang {$targetUser->name} adalah {$request->role}",
        ]);
    }

    public function showUser()
    {
        $users = User::latest()->paginate(10);
        return UserResource::collection($users);
    }
}

