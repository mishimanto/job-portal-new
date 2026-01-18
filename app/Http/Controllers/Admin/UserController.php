<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Start query
        $query = User::withCount(['jobApplications', 'postedJobs']);
        
        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Sort by latest
        $query->orderBy('created_at', 'desc');
        
        $users = $query->paginate(10);
        
        // Get statistics
        $totalUsers = User::count();
        $adminsCount = User::where('role', 'admin')->count();
        $jobSeekersCount = User::where('role', 'job_seeker')->count();
        $activeTodayCount = User::whereDate('created_at', today())->count();
        
        // AJAX response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'users' => $users,
                'stats' => [
                    'total' => $totalUsers,
                    'admins' => $adminsCount,
                    'job_seekers' => $jobSeekersCount,
                    'active_today' => $activeTodayCount
                ]
            ]);
        }
        
        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminsCount',
            'jobSeekersCount',
            'activeTodayCount'
        ));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,job_seeker',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    // public function show(User $user)
    // {
    //     $user->load([
    //         'educations',
    //         'experiences',
    //         'skills',
    //         'projects',
    //         'certifications',
    //         'socialLinks',
    //         'jobApplications',
    //         'postedJobs'
    //     ]);
        
    //     return view('admin.users.show', compact('user'));
    // }

    // public function edit(User $user)
    // {
    //     return view('admin.users.edit', compact('user'));
    // }

    // public function update(Request $request, User $user)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'role' => 'required|in:admin,job_seeker',
    //         'is_active' => 'boolean',
    //     ]);

    //     if ($request->has('password') && $request->password) {
    //         $request->validate([
    //             'password' => ['confirmed', Rules\Password::defaults()],
    //         ]);
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->role = $request->role;
    //     $user->is_active = $request->boolean('is_active');
    //     $user->save();

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User updated successfully',
    //             'user' => $user
    //         ]);
    //     }

    //     return redirect()->route('admin.users.index')
    //         ->with('success', 'User updated successfully.');
    // }

    public function destroy(User $user)
    {
        // Prevent deleting admin users
        if ($user->role === 'admin') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete admin users.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'Cannot delete admin users.');
        }

        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'is_active' => $user->is_active
            ]);
        }

        return redirect()->back()
            ->with('success', 'User status updated successfully.');
    }
}