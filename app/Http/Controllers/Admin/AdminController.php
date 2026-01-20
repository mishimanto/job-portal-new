<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        $query = User::where('role', 'admin')
                    ->orderBy('is_super_admin', 'desc')
                    ->orderBy('created_at', 'desc');
        
        // Apply filters if any
        if (request()->has('search') && request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if (request()->has('type')) {
            if (request('type') === 'super') {
                $query->where('is_super_admin', true);
            } elseif (request('type') === 'normal') {
                $query->where('is_super_admin', false);
            }
        }
        
        if (request()->has('status')) {
            if (request('status') === 'active') {
                $query->where('is_active', true);
            } elseif (request('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $admins = $query->paginate(10);
        
        // Statistics
        $superAdminsCount = User::where('role', 'admin')->where('is_super_admin', true)->count();
        $activeAdminsCount = User::where('role', 'admin')->where('is_active', true)->count();
        $recentAdminsCount = User::where('role', 'admin')
                                ->where('created_at', '>=', now()->subDays(7))
                                ->count();
        
        // AJAX request হলে JSON response দিবে
        if (request()->ajax()) {
            return response()->json([
                'admins' => $admins,
                'stats' => [
                    'superAdmins' => $superAdminsCount,
                    'activeAdmins' => $activeAdminsCount,
                    'recentAdmins' => $recentAdminsCount,
                ]
            ]);
        }
        
        return view('admin.admins.index', compact('admins', 'superAdminsCount', 'activeAdminsCount', 'recentAdminsCount'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_super_admin' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'is_super_admin' => $request->has('is_super_admin') ? 1 : 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    // public function edit(User $admin)
    // {
    //     if ($admin->role !== 'admin') {
    //         abort(403, 'Only admin users can be edited.');
    //     }

    //     return view('admin.admins.edit', compact('admin'));
    // }

    // public function update(Request $request, User $admin)
    // {
    //     if ($admin->role !== 'admin') {
    //         abort(403, 'Only admin users can be updated.');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'is_super_admin' => 'nullable|boolean',
    //         'is_active' => 'nullable|boolean',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'is_super_admin' => $request->has('is_super_admin') ? 1 : 0,
    //         'is_active' => $request->has('is_active') ? 1 : 0,
    //     ];

    //     if ($request->filled('password')) {
    //         $data['password'] = Hash::make($request->password);
    //     }

    //     $admin->update($data);

    //     return redirect()->route('admin.admins.index')
    //         ->with('success', 'Admin updated successfully.');
    // }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'You cannot delete yourself.');
        }

        if ($admin->role !== 'admin') {
            abort(403, 'Only admin users can be deleted.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }

    public function toggleStatus(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(403, 'Only admin users can be toggled.');
        }
        
        if ($admin->id === auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot change your own status.'
                ], 403);
            }
            
            return redirect()->back()
                ->with('error', 'You cannot change your own status.');
        }
        
        $admin->update([
            'is_active' => !$admin->is_active
        ]);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Admin status updated successfully.',
                'is_active' => $admin->is_active
            ]);
        }
        
        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin status updated successfully.');
    }
}