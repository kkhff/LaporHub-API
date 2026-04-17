<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalReports = Report::count();
        $pending = Report::where('status', 'pending')->count();
        $admin = User::where('role', 'admin')->count();
        $masyarakat = User::where('role', 'masyarakat')->count();
        $petugas = User::where('role', 'petugas')->count();

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
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:petugas,admin,masyarakat'
        ]);


        if($request->user()->id ==$id) {
            return response()->json([
                'message' => 'Anda tidak dapat merubah role sendiri!'
            ], 403);
        }

        $user->update([
            'role' => $request->role,
        ]);

        $user->refresh();

        return (new UserResource($user))->additional([
            'success' => true,
            'message' => "Berhasil! sekarang {$user->name} adalah {$request->role}",
        ]);
    }
    public function showUser()
    {
        $users = User::latest()->paginate(10);
        return UserResource::collection($users);
    }
}
