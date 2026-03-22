<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminAuditLog;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = User::where('role', 'resident');
            
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('flat_number', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            }

            $residents = $query->orderBy('created_at', 'desc')->get();
            return response()->json(['success' => true, 'data' => $residents], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'flat_number' => 'required|string',
                'password' => 'nullable|string|min:6',
            ]);

            $resident = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password ?: 'password123'),
                'role' => 'resident',
                'flat_number' => $request->flat_number,
                'society_id' => $request->society_id ?: 1,
            ]);

            AdminAuditLog::create([
                'user_id' => $resident->id,
                'action' => 'Resident Created',
                'description' => "Resident {$resident->name} (Flat: {$resident->flat_number}) was created.",
                'ip_address' => $request->ip(),
            ]);

            return response()->json(['success' => true, 'data' => $resident], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $resident = User::findOrFail($id);
            $data = $request->only(['name', 'email', 'flat_number', 'phone', 'block']);
            $data['role'] = 'resident'; // Ensure role stays as resident
            $resident->update($data);
            return response()->json(['success' => true, 'data' => $resident], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $resident = User::findOrFail($id);
            $resident->delete();
            return response()->json(['success' => true, 'message' => 'Resident deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
